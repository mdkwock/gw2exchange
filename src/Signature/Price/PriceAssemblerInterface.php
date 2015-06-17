<?php
namespace GW2ledger\Signature\Price;

use GW2ledger\Signature\Base\AssemblerInterface;

/**
 * This interface is to fetch and retrieve prices
 */
interface PriceAssemblerInterface extends AssemblerInterface
{
  /**
   * gets an array of prices for a particular item, optionally restrained by the number and the starting point
   * @param  int|int[]    $itemIds  the id of the item that we are looking up
   * @return Price[]       an array of price objects for the item
   */
  public function getByItemIds($itemId);
}