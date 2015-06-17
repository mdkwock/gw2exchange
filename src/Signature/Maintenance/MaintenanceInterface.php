<?php
namespace GW2Exchange\Signature\Maintenance;

/**
 * This interface is for classes that keep the database up to date with the guildwars2 servers
 */
interface MaintenanceInterface
{
  /**
   * this will return a list of all of the things that need to be refreshed
   * if the staleDateTime is passed, then every entry that hasn't been touched since that day will be ran
   * if no datetime is passed, then it will only return nonexisting ones
   * @return int[]   all of the ids which need to be run
   */
  public function getToDoList(\DateTime $staleDateTime = null);

  /**
   * this will return a DateTime object which will be set to the last time the maintenance ran
   * @return DateTime    the last time the maintenance ran
   */
  public function getLastRun();

  /**
   * runs the maintenance, optionally for the ids passed to it, otherwise it will run every id
   * @param  int[]  $ids  specifies which ids should be run 
   */
  public function runMaintenance($ids = array()); //it should either throw an exception or return false on error, haven't decided
}