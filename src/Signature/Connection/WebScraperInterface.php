<?php
namespace GW2Exchange\Signature\Connection;

/**
 * This class takes in a properly formatted url and retrieves the data
 */
interface WebScraperInterface
{
  /**
   * goes to the url and returns the data in
   * @param  string $url the endpoint that we are reading
   * @return string  json the response from the server
   */
  public function getInfo($url);
}