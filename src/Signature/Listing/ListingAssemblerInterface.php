<?php
namespace GW2Exchange\Signature\Listing;

use GW2Exchange\Signature\Base\AssemblerInterface;

/**
 * This interface is to fetch and retrieve listings
 */
interface ListingAssemblerInterface extends AssemblerInterface
{


  /**
   * returns a list of item ids, the ones listed are the ones with current listings available
   * @return int[]
   */
  public function getIdList();

  /**
   * gets an array of listings for a particular item, optionally restrained by the number and the starting point
   * @param  int|int[]    $itemIds  the ids of the item that we are looking up
   * @param  int    $count   the number of listings we are returning, -1 means all of them
   * @param  int    $start   the number of listings that we are skipping
   * @return Listing[]       an array of listing objects for the item
   */
  public function getByItemIds($itemId, $count = -1, $start = 0);
  
  /**
   * this function will return an instance of an Item
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Item
   * @return  Item      the created object
   */
  public function createFromJson($json);

}