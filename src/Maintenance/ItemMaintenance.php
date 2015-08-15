<?php
namespace GW2Exchange\Maintenance;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;
use GW2Exchange\Item\ItemAssembler;
use GW2Exchange\Item\ItemStorage;


use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\ItemTableMap;
/**
 * This interface is for classes that keep the database up to date with the guildwars2 servers
 * This tests against the database rather than using the assembler for some reason that i can't think of (maybe for less code to write right now)
 */
class ItemMaintenance implements MaintenanceInterface
{
  protected $itemAssembler;
  protected $itemStorage;

  public function __construct(ItemAssembler $ia, ItemStorage $is)
  {
    $this->itemAssembler = $ia;
    $this->itemStorage = $is;
  }

  /**
   * this will return a list of all of the things that need to be refreshed
   * if the staleDateTime is passed, then every entry that hasn't been touched since that day will be ran
   * if no datetime is passed, then it will only return nonexisting ones
   *
   * load new is a special setting which will create all of the items that are not in the database already
   * @return int[]   all of the ids which need to be run
   */
  protected function getToDoList()
  {
    //find a list of items that are old which need to be run
    $pickList = $this->getStaleCache();
    //find items that are valid items according to the gw2 api server
    $masterItemList = $this->itemAssembler->getIdList();

    $newItems = $this->loadNewItems($masterItemList);
    //new items come before updates to existing items
    $toDoList = array_merge($newItems,$pickList);

    //find items that are both on the todo list and on the master list
    //flip both arrays bc intersect key is much faster than intersect and we know they are unique
    $flippedMasterItemList = array_flip($masterItemList);
    $flippedToDoList = array_flip($toDoList);//flip it back to preserve original order
    $flippedToDoList = array_intersect_key($flippedToDoList,$flippedMasterItemList);
    $toDoList = array_keys($flippedToDoList);//flip it back to preserve rather than renumbering it
    return $toDoList;
  }

  /**
   * this function loads all of the items from both the storage and the gw2 servers
   * it then adds all items not found in the storage to the storage to allow for them to be updated like the rest
   * choosing this method even though it is not that great, for simplicity sake
   * its not optimal because you have to hit the database twice
   *
   * @param  int[] $masterItemList  an array of all the items from the gw2 server
   * @return int[]                  the ids of items that aren't in the database
   */
  protected function loadNewItems($masterItemList){
    $currentItemList = $this->itemStorage->getAllItemIds();
    $flippedCurrentItemList = array_flip($currentItemList);
    $flippedMasterItemList = array_flip($masterItemList);
    $newItemList = array_diff_key($flippedMasterItemList,$flippedCurrentItemList);
    $newItemList = array_keys($newItemList);
    return $newItemList;
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
    $sql = "SELECT id
           FROM item
           WHERE
            CONVERT_TZ(NOW(),'+00:00','-04:00') > date_add(updated_at, Interval (cache_time) DAY)
             ORDER BY (CONVERT_TZ(NOW(),'+00:00','-04:00') - date_add(updated_at, Interval (cache_time) DAY)) DESC";
    $this->itemStorage->prepareCustomQuery($sql);
    $data = $this->itemStorage->fetchAllCustomQuery();
    $items = array();
    foreach ($data as $id) {
      $items[] = $id['id'];
    }
    return $items;
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