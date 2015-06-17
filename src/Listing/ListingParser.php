<?php
namespace GW2ledger\Listing;

use GW2ledger\Signature\Listing\ListingParserInterface;

/**
 * This class takes in a json string and creates an array
 * where all of the required fields for an listing are converted to the right format for saving
 *
 * This class was made so that there is a intermediate class surrounding the GW2 endpoint
 * in case there is a change at the end point
 */
class ListingParser implements ListingParserInterface
{
  /**
   * takes a json string and finds the variables which are used in the Listing object.
   *
   * formats as an array of arrays with all of the information for each listing contained in a single array.
   * this way we have a nice and easy uniform way of passing them around if we ever need to, without worrying about not having all the info
   *
   * @param  string $json the json string sent by the server, which is being processed
   * @return array  a mixed array which contains all the parts necessary to making an Listing
   */
  public function parseJson($json)
  {
    $objs = json_decode($json,true);
    $return = array();//the returned array value
    foreach ($objs as $obj) {    
      $itemId = $obj['id'];//the item id the listing is for
      $parsed = array();
      foreach($obj['buys'] as $listing){
        //for each buy listing
        $list = array("ItemId"=>$itemId,"Type"=>"buy");//the starting data for each listing in this set
        $list["Orders"] = $listing['listings'];//the number of orders for this price
        $list["UnitPrice"] = $listing["unit_price"];
        $list['Quantity'] = $listing['quantity'];
        $parsed[] = $list;
      }
      foreach($obj['sells'] as $listing){
        //for each sell listing
        $list = array("ItemId"=>$itemId,"Type"=>"sell");//the starting data for each listing in this set
        $list["Orders"] = $listing['listings'];//the number of orders for this price
        $list["UnitPrice"] = $listing["unit_price"];
        $list['Quantity'] = $listing['quantity'];
        $parsed[] = $list;
      }
      $return[$itemId] = $parsed;
    }
    return $return;
  }

  /**
   * This function parses the result of the endpoint list.
   * This is a list of items with current listings.
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