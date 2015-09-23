<?php
namespace GW2Exchange\Maintenance;

use GuzzleHttp\Exception\RequestException;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;
use GW2Exchange\Signature\Price\PriceAssemblerInterface;
use GW2Exchange\Price\PriceStorage;
use GW2Exchange\Item\ItemStorage;

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
  protected $priceStorage;
  protected $itemStorage;
  public function __construct(PriceAssemblerInterface $pa, PriceStorage $ps, ItemStorage $is)
  {
    $this->priceAssembler = $pa;
    $this->priceStorage = $ps;
    $this->itemStorage = $is;
  }

  /**
   * this will return a list of all of the things that need to be refreshed
   * if the staleDateTime is passed, then every entry that hasn't been touched since that day will be ran
   * if no datetime is passed, then it will only return nonexisting ones
   * @param  int  $maxRecords   the maximum number of records returned
   * @return int[]   all of the ids which need to be run
   */
  public function getToDoList($maxRecords = -1)
  {
    $toDoList = array();
    try{
      //find prices that are up to date and pick them, do not run items that no longer return answers for them
      $stalePickList = $this->getStaleCache();

      //master list is a list of all valid prices (item in item table and price on gw2 servers)
      //get a list from the gw2 server of all the prices in the game
      $masterPriceList = $this->priceAssembler->getIdList();
      //get a list from the database about what items we are tracking
      $masterItemList = $this->itemStorage->getAllItemIds();
      //check that all of the prices refer to valid items
      $flippedMasterPriceList = array_flip($masterPriceList);
      $flippedMasterItemList = array_flip($masterItemList);
      $flippedMasterList = array_intersect_key($flippedMasterItemList,$flippedMasterPriceList);//find the prices of only valid items
      $masterList = array_keys($flippedMasterList);
      //only get prices which still exist   
      //get all of the prices which are not in the database
      $newPrices = $this->loadNewPriceItems($masterList);    //new item prices come before updates to existing items
      //dd($newPrices);
      $toDoList = array_merge($newPrices,$stalePickList);
      $flippedToDoList = array_flip($toDoList);
      $flippedToDoList = array_intersect_key($flippedToDoList,$flippedMasterList);
      $toDoList = array_keys($flippedToDoList);
      if($maxRecords > 0){
        //if we are passing in a max records limit
        $toDoList = array_slice($toDoList, 0, $maxRecords);
      }
      
    }catch(RequestException $e){

    }
    return $toDoList;
  }

  /**
   * This function will return a list of items that are past their cache time in decsending differences
   * meaning that an item that is 2 min past its cache time, it is before an item that is 1 min past
   * even if the 1 min item hasn't been checked in an hour
   * @return [type] [description]
   */
  protected function getStaleCache(){
    //find the items that the cache time has expired
    //this is equal to saying the current time is after the cache time
    //had to adjust mysqls idea of the time bc of some timezone issue may not be needed on other servers
    $sql = "SELECT item_id
           FROM price
           WHERE
            CONVERT_TZ(NOW(),'+00:00','-04:00') > date_add(updated_at, Interval (cache_time) MINUTE)
             ORDER BY (CONVERT_TZ(NOW(),'+00:00','-04:00') - date_add(updated_at, Interval (cache_time) MINUTE)) DESC";
    $this->priceStorage->prepareCustomQuery($sql);
    $data = $this->priceStorage->fetchAllCustomQuery();
    $items = array();
    foreach ($data as $id) {
      $items[] = $id['item_id'];
    }
    return $items;
  }


  /**
   * this function loads all of the prices from both the storage and the gw2 servers
   * it then adds all prices for items not found in the storage to the storage to allow for them to be updated like the rest
   * choosing this method even though it is not that great for simplicity sake 
   * its not optimal because you have to hit the database twice     
   *
   * @param  int[] $masterItemList  an array of all the items from the gw2 server
   * @return int[]                  the ids of prices that aren't in the database
   */
  protected function loadNewPriceItems($masterPriceList){
    $currentPriceList = $this->priceStorage->getAllItemIds();
    $flippedCurrentPriceList = array_flip($currentPriceList);
    $flippedMasterPriceList = array_flip($masterPriceList);
    //get all the prices that aren't in the database
    $newPriceList = array_diff_key($flippedMasterPriceList,$flippedCurrentPriceList); //use array diff keys bc its faster than otherwise
    $newPriceList = array_keys($newPriceList);
    return $newPriceList;
  }

  /**
   * runs the maintenance, optionally for the ids passed to it, otherwise it will run every id
   * @param  int[]  $ids  specifies which ids should be run
   * @param  DateTime  $ids  specifies which ids should be run
   */
  public function runMaintenance($ids = array())
  {
    if(empty($ids)){
      //if we are not given a set of ids, figure out what they should be
      //find the list of ids based on old ones from the database
      $ids = $this->getToDoList(); //get the list of ids to run based on the optional expiration time
    }
    $endTime = time();
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
    return $numLeft;
  }
}