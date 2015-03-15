<?php
namespace GW2ledger\Signature\Listing;

/**
 * This interface is to fetch and retrieve listings
 */
interface ListingAssemblerInterface
{
  /**
   * gets an array of listings for a particular item, optionally restrained by the number and the starting point
   * @param  int    $itemId  the id of the item that we are looking up
   * @param  int    $count   the number of listings we are returning, -1 means all of them
   * @param  int    $start   the number of listings that we are skipping
   * @return Listing[]       an array of listing objects for the item
   */
  public function getByItemId($itemId, $count = -1, $start = 0);
}