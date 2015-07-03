<?php
namespace GW2Exchange\Signature\Maintenance;

/**
 * This interface is for classes that keep the database up to date with the guildwars2 servers
 */
interface MaintenanceInterface
{
  /**
   * runs the maintenance, optionally for the ids passed to it, otherwise it will run every id
   * @param  int[]  $ids  specifies which ids should be run 
   */
  public function runMaintenance($ids = array()); //it should either throw an exception or return false on error, haven't decided
}