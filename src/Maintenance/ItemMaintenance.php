<?php
namespace GW2Exchange\Maintenance;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;
use GW2Exchange\Item\ItemAssembler;

use GW2Exchange\Database\ItemQueryFactory;


use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\ItemTableMap;
/**
 * This interface is for classes that keep the database up to date with the guildwars2 servers
 * This tests against the database rather than using the assembler for some reason that i can't think of (maybe for less code to write right now)
 */
class ItemMaintenance implements MaintenanceInterface
{
  protected $itemAssembler;
  protected $itemQueryFactory;

  public function __construct(ItemAssembler $ia, ItemQueryFactory $iqf)
  {
    $this->itemAssembler = $ia;
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
    $itemQuery = $this->itemQueryFactory->createQuery();
    if($staleDateTime !== null){
      //if we pass in a stale datetime
      $itemQuery->filterByUpdatedAt(array("min"=>$staleDateTime->format('Y-m-d H:i:s'))); //only take the ones older than the given
    }
    //$skipList = $itemQuery->select('ItemId')->find()->toArray(); //this is all of the items in the database that are young enough to be skipped
    $pickList = $this->getStaleCache();
    //get a list from the gw2 server of all the items in the game
    $masterItemList = $this->itemAssembler->getIdList();
    $masterItemList = $this->itemAssembler->getIdList();
    //check that all of the items refer to valid items
    $masterItemList = array_flip($masterItemList);
    $masterItemList = array_flip($masterItemList);

    $masterList = array_intersect_key($masterItemList,$masterItemList);//find the items of only valid items
    //find items that are up to date and pick them, do not run items that no longer return answers them
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
    $con = Propel::getWriteConnection(ItemTableMap::DATABASE_NAME);
    //find the items that the cache time has expired
    //this is equal to saying the current time is after the cache time
    //had to adjust mysqls idea of the time bc of some timezone issue may not be needed on other servers
    $sql = "SELECT id
           FROM item
           WHERE
            CONVERT_TZ(NOW(),'+00:00','-04:00') > date_add(updated_at, Interval (cache_time) MINUTE)
             ORDER BY (CONVERT_TZ(NOW(),'+00:00','-04:00') - date_add(updated_at, Interval (cache_time) MINUTE)) DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    $items = array();
    foreach ($data as $id) {
      $items[] = $id['id'];
    }
    return $items;

  }

  /**
   * this will return a DateTime object which will be set to the last time the maintenance ran
   * @return DateTime    the last time the maintenance ran
   */
  public function getLastRun()
  {
    $lastUpdated = $this->itemQueryFactory->createQuery()->lastUpdatedFirst()->findOne();
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
    if(!empty($ids)){
      $items = $this->itemAssembler->getByIds($ids);//get all the ids at once
      //then save them all
      foreach ($items as $item) {
        $item->save();
      }      
    }
    return count($ids);
  }
}