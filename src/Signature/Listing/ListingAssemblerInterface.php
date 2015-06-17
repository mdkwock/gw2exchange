<?php
namespace GW2ledger\Signature\Listing;

use GW2ledger\Signature\Base\AssemblerInterface;

/**
 * This interface is to fetch and retrieve listings
 */
interface ListingAssemblerInterface extends AssemblerInterface
{
  /**
   * gets an array of listings for a particular item, optionally restrained by the number and the starting point
   * @param  int|int[]    $itemIds  the ids of the item that we are looking up
   * @param  int    $count   the number of listings we are returning, -1 means all of them
   * @param  int    $start   the number of listings that we are skipping
   * @return Listing[]       an array of listing objects for the item
   */
  public function getByItemIds($itemId, $count = -1, $start = 0);
}