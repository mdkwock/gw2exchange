<?php
namespace GW2ledger\Signature\Base;

/**
 * This interface takes in a json string and creates an array
 * where all of the required fields for an object are converted to the right format for saving
 *
 * This interface was made so that there is a intermediate interface surrounding the GW2 endpoint
 * in case there is a change at the end point, does not care what you do with the data just makes it a uniform array
 */
interface ParserInterface
{
  /**
   * takes a json string and finds the variables which are used in the object.
   *
   * at the moment it doesn't do any processing on the json string, just converts it into a php array
   * possibly later it could do preprocessing on the array to make it easier to work with
   * 
   * @param  string $json the json string sent by the server, which is being processed
   * @return array  a mixed array which contains all the parts necessary to making an object
   */
  public function parseJson($json);
}