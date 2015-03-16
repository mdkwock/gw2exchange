<?php
namespace GW2ledger\Price;

use GW2ledger\Signature\Price\PriceParserInterface;

/**
 * This class takes in a json string and creates an array
 * where all of the required fields for an price are converted to the right format for saving
 *
 * This class was made so that there is a intermediate class surrounding the GW2 endpoint
 * in case there is a change at the end point
 */
class PriceParser implements PriceParserInterface
{
  /**
   * takes a json string and finds the variables which are used in the Price object.
   *
   * formats as an array of arrays with all of the information for each price contained in a single array.
   * this way we have a nice and easy uniform way of passing them around if we ever need to, without worrying about not having all the info
   *
   * @param  string $json the json string sent by the server, which is being processed
   * @return array  a mixed array which contains all the parts necessary to making an Price
   */
  public function parseJson($json)
  {
    $obj = json_decode($json,true);
    $itemId = $obj['id'];//the item id the price is for
    $price = array("ItemId"=>$itemId);//the starting data for each price in this set
    $price['BuyPrice'] = $obj['buys']['unit_price'];
    $price['BuyQty'] = $obj['buys']['quantity'];
    $price['SellPrice'] = $obj['sells']['unit_price'];
    $price['SellQty'] = $obj['sells']['quantity'];
    return $price;
  }


  /**
   * This function parses the result of the endpoint list.
   * This is a list of items with price values (current listings).
   *
   * this function doesnt do much right now, only returns a list of ints
   * @return int[]    a list of ids
   */
  public function parseList($json)
  {
    $arr = json_decode($json,true);
    return $arr;
  }
}