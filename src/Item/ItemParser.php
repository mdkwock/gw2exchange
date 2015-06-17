<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Item\ItemParserInterface;

/**
 * This class takes in a json string and creates an array
 * where all of the required fields for an item are converted to the right format for saving
 *
 * This class was made so that there is a intermediate class surrounding the GW2 endpoint
 * in case there is a change at the end point
 */
class ItemParser implements ItemParserInterface
{
  /**
   * takes a json string and finds the variables which are used in the item object.
   *
   * converts the keys into PascalCase because that is the default for propel getByName
   *
   * Assume that we are handed an array of items
   *
   * @param  string $json the json string sent by the server, which is being processed
   * @return array  a mixed array which contains all the parts necessary to making an item
   */
  public function parseJson($json)
  {
    $objs = json_decode($json,true);
    $return = array();//the returned array value
    foreach ($objs as $one) {
      $parsed = array();      
      foreach($one as $key=>$value){
        //for each item convert from snake_case to PascalCase
        $pattern = '/_(\w)/';
        $nKey = ucfirst(preg_replace_callback($pattern, function($matches){ return strtoupper($matches[1]);}, $key));
        $parsed[$nKey] = $value;
      }
      $return[$parsed['Id']] = $parsed;
    }
    return $return;
  }

  /**
   * This function parses the result of the endpoint list.
   * This is a list of all items which currently exist in game
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