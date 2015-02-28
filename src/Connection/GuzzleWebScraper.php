<?php
namespace GW2ledger\Connection;

use GuzzleHttp\Client;

use \GW2ledger\Signature\Connection\WebScraperInterface;

class GuzzleWebScraper implements WebScraperInterface
{
  private $guzzleClient;

  public function __construct()
  {
    $this->guzzleClient = new Client();
  }

  public function getInfo($url){
    $response = $this->guzzleClient->get($url);
    return $response->getBody();
  }
}