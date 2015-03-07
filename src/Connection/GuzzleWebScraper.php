<?php
namespace GW2ledger\Connection;

use GuzzleHttp\Client;

use \GW2ledger\Signature\Connection\WebScraperInterface;

/**
 * This class takes in a properly formatted url and retrieves the data
 */
class GuzzleWebScraper implements WebScraperInterface
{
  private $guzzleClient;

  public function __construct(Client $clientClass)
  {
    $this->guzzleClient = $clientClass;
  }

  /**
   * goes to the url and returns the data in
   * @param  string $url the endpoint that we are reading
   * @return string  json the response from the server
   */
  public function getInfo($url){
    $response = $this->guzzleClient->get($url);
    return $response->getBody();
  }
}