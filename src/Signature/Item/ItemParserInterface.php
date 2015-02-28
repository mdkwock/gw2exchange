<?php
namespace gw2ledger\ItemParserInterface;

/**
 * This class takes in a json string and creates an array
 * where all of the required fields for an item are converted to the right format for saving
 *
 * This class was made so that there is a intermediate class surrounding the GW2 endpoint
 * in case there is a change at the end point
 */
interface ItemParserInterface
{
  /**
   * takes a json string and finds the variables which are used in the item object.
   * @param  string $url the endpoint that we are reading
   * @return string  json the response from the server
   */
  public function parseJson($json);
}