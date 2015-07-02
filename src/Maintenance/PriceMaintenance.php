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
    //$skipList = $priceQuery->select('ItemId')->find()->toArray(); //this is all of the prices in the database that are young enough to be skipped
    $pickList = $this->getStaleCache();
    //get a list from the gw2 server of all the prices in the game
    $masterPriceList = $this->priceAssembler->getIdList();
    $masterItemList = $this->itemAssembler->getIdList();
    //check that all of the prices refer to valid items
    $masterPriceList = array_flip($masterPriceList);
    $masterItemList = array_flip($masterItemList);

    $masterList = array_intersect_key($masterItemList,$masterPriceList);//find the prices of only valid items
    //find prices that are up to date and pick them, do not run items that no longer return answers them
    $pickList = array_flip($pickList);
    $toDoList = array_intersect_key($pickList,$masterList); //use array diff keys bc its faster than otherwise
    $toDoList = array_keys($toDoList);
    return $toDoList;
  }

  /**
   * This function will return a list of items that are past their cache time in decsending differences
   * meaning that an item that is 2 min past its cache time, it is before an item that is 1 min past
   * even if the 1 min item hasn't been checked in an hour
   * @return [type] [description]
   */
  public function getStaleCache(){
    $con = Propel::getWriteConnection(PriceTableMap::DATABASE_NAME);
    //find the items that the cache time has expired
    //this is equal to saying the current time is after the cache time
    //had to adjust mysqls idea of the time bc of some timezone issue may not be needed on other servers
    $sql = "SELECT item_id
           FROM price
           WHERE
            CONVERT_TZ(NOW(),'+00:00','-04:00') > date_add(updated_at, Interval (cache_time) MINUTE)
             ORDER BY (CONVERT_TZ(NOW(),'+00:00','-04:00') - date_add(updated_at, Interval (cache_time) MINUTE)) DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    $prices = array();
    foreach ($data as $id) {
      $prices[] = $id['item_id'];
    }
    return $prices;

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
    //dd($prices);
    return $numLeft;
  }
}