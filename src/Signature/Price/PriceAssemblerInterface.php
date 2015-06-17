<?php
namespace GW2Exchange\Signature\Price;

use GW2Exchange\Signature\Base\AssemblerInterface;

/**
 * This interface is to fetch and retrieve prices
 */
interface PriceAssemblerInterface extends AssemblerInterface
{

  /**
   * returns a list of item ids, the ones listed are the ones with current prices available
   * @return int[]
   */
  public function getIdList();
  
  /**
   * gets an array of prices for a particular item, optionally restrained by the number and the starting point
   * @param  int|int[]    $itemIds  the id of the item that we are looking up
   * @return Price[]       an array of price objects for the item
   */
  public function getByItemIds($itemId);

  /**
   * this function will return an instance of a Price
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Price
   * @return  Price      the created object
   */
  public function createFromJson($json);
}