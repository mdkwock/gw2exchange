<?php
namespace GW2Exchange\Maintenance;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;
use GW2Exchange\Signature\Price\PriceAssemblerInterface;
use \GW2Exchange\Signature\Item\ItemAssemblerInterface;

use GW2Exchange\Database\PriceQueryFactory;

use GW2Exchange\Database\ItemQueryFactory;

use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\PriceTableMap;
/**
 * This interface is for classes that keep the database up to date with the guildwars2 servers
 * This tests against the database rather than using the assembler for some reason that i can't think of (maybe for less code to write right now)
 */
class PriceMaintenance implements MaintenanceInterface
{
  protected $priceAssembler;
  protected $itemAssembler;
  protected $priceQueryFactory;
  protected $itemQueryFactory;

  public function __construct(PriceAssemblerInterface $pa, ItemAssemblerInterface $ia, PriceQueryFactory $pqf, ItemQueryFactory $iqf)
  {
    $this->priceAssembler = $pa;
    $this->itemAssembler = $ia;
    $this->priceQueryFactory = $pqf;
    $this->itemQueryFactory = $iqf;
  }

  /**
   * this will return a list of all of the things that need to be refreshed
   * if the staleDateTime is passed, then every entry that hasn't been touched since that day will be ran
   * if no datetime is passed, then it will only return nonexisting ones
   * @return int[]   all of the ids which need to be run
   */
  public function getToDoList(\DateTime $staleDateTime = null)
  {
    $priceQuery = $this->priceQueryFactory->createQuery();
    if($staleDateTime !== null){
      //if we pass in a stale datetime
      $priceQuery->filterByUpdatedAt(array("min"=>$staleDateTime->format('Y-m-d H:i:s'))); //only take the ones older than the given
    }
    $skipList = $priceQuery->select('ItemId')->find()->toArray(); //this is all of the prices in the database that are young enough to be skipped
    //d($skipList);
    //get a list from the gw2 server of all the prices in the game
    $masterPriceList = $this->priceAssembler->getIdList();
    $masterItemList = $this->itemAssembler->getIdList();
    //check that all of the prices refer to valid items
    $masterPriceList = array_flip($masterPriceList);
    $masterItemList = array_flip($masterItemList);
    
    $masterList = array_intersect_key($masterItemList,$masterPriceList);//find the prices of only valid items
    //find prices that are up to date and skip them
    $skipList = array_flip($skipList);
    $toDoList = array_diff_key($masterList,$skipList); //use array diff keys bc its faster than otherwise
    $toDoList = array_keys($toDoList);
    return $toDoList;
  }

  /**
   * this will return a DateTime object which will be set to the last time the maintenance ran
   * @return DateTime    the last time the maintenance ran
   */
  public function getLastRun()
  {
    $lastUpdated = $this->priceQueryFactory->createQuery()->lastUpdatedFirst()->findOne();
    $ans = $lastUpdated->getUpdatedAt();
    $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $ans);
    return $dateTime;
  }

  /**
   * runs the maintenance, optionally for the ids passed to it, otherwise it will run every id
   * @param  int[]  $ids  specifies which ids should be run 
   * @param  DateTime  $ids  specifies which ids should be run 
   */
  public function runMaintenance($ids = array(),$staleDateTime = null)
  {
    if(empty($ids)){
      //if we are not given a set of ids, figure out what they should be
      //find the list of ids based on old ones from the database
      $ids = $this->getToDoList($staleDateTime); //get the list of ids to run based on the optional expiration time
    }
    /*
    //archive any existing prices
    $oldPrices = $this->priceQueryFactory->createQuery()->filterByItemId($ids)->find();//get all old prices
    foreach ($oldPrices as $price) {
      $price->archive();
    }
    */
    //use the count ids bc the assembler rate limits us
    $numLeft = count($ids);
    //get new prices
    $prices = $this->priceAssembler->getByItemIds($ids);//get all the ids at once
    //then save them all
    if(empty($prices)){
      //if nobody has any price info
      return 0;
    }else{
      try{
  //      $con = Propel::getWriteConnection(PriceTableMap::DATABASE_NAME);
//$con->useDebug(true);
        foreach ($prices as $price) {
          $price->save();
          $numLeft--;
        }
      }catch(\Exception $e){
        d($ids);
        d($e);
        dd($price);      
      }
    }  
    return $numLeft;  
  }
}