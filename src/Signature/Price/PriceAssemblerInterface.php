<?php
namespace GW2ledger\Signature\Price;

/**
 * This interface is to fetch and retrieve prices
 */
interface PriceAssemblerInterface
{
  /**
   * gets an array of prices for a particular item, optionally restrained by the number and the starting point
   * @param  int    $itemId  the id of the item that we are looking up
   * @param  int    $count   the number of prices we are returning, -1 means all of them
   * @param  int    $start   the number of prices that we are skipping
   * @return Price[]       an array of price objects for the item
   */
  public function getByItemId($itemId);
}