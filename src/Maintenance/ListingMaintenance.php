<?php
namespace GW2Exchange\Maintenance;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;
use GW2Exchange\Listing\ListingAssembler;

use GW2Exchange\Database\ListingQueryFactory;

use GW2Exchange\Database\ItemQueryFactory;

/**
 * This interface is for classes that keep the database up to date with the guildwars2 servers
 * This tests against the database rather than using the assembler for some reason that i can't think of (maybe for less code to write right now)
 */
class ListingMaintenance implements MaintenanceInterface
{
  protected $listingAssembler;
  protected $listingQueryFactory;
  protected $itemQueryFactory;

  public function __construct(ListingAssembler $la, ListingQueryFactory $lqf, ItemQueryFactory $iqf)
  {
    $this->listingAssembler = $la;
    $this->listingQueryFactory = $lqf;
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
    $listingQuery = $this->listingQueryFactory->createQuery();
    if($staleDateTime !== null){
      //if we pass in a stale datetime
      $listingQuery->filterByUpdatedAt(array("min"=>$staleDateTime->format('Y-m-d H:i:s'))); //only take the ones older than the given
    }
    $skipList = $listingQuery->select('id')->find()->toArray(); //this is all of the listings in the database that are young enough to be skipped
    //get a list from the gw2 server of all the listings in the game
    $masterListingList = $this->listingAssembler->getIdList();

      if(count($skipList)<2){
        var_dump($skipList);
        var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,4));
        die();
      }
    $toDoList = array_diff($masterListingList,$skipList);
    return $toDoList;
  }

  /**
   * this will return a DateTime object which will be set to the last time the maintenance ran
   * @return DateTime    the last time the maintenance ran
   */
  public function getLastRun()
  {
    $lastUpdated = $this->listingQueryFactory->createQuery()->lastUpdatedFirst()->findOne();
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
    $listings = $this->listingAssembler->getByItemIds($ids);//get all the ids at once
    //then save them all
    foreach ($listings as $listing) {
      $listing->save();
    }
    return count($ids);
  }
}