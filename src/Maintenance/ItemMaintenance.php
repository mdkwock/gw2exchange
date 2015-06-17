<?php
namespace GW2Exchange\Maintenance;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;
use GW2Exchange\Item\ItemAssembler;

use GW2Exchange\Database\ItemQueryFactory;

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
    $skipList = $itemQuery->select('id')->find()->toArray(); //this is all of the items in the database that are young enough to be skipped
    //get a list from the gw2 server of all the items in the game
    $masterItemList = $this->itemAssembler->getIdList();

    //find prices that are up to date and skip them
    $masterItemList = array_flip($masterItemList);
    $skipList = array_flip($skipList);
    $toDoList = array_diff_key($masterItemList,$skipList); //use array diff keys bc its faster than otherwise
    $toDoList = array_keys($toDoList);
    return $toDoList;
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