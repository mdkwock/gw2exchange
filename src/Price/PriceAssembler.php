<?php
namespace GW2ledger\Price;

use \GW2ledger\Signature\Connection\WebScraperInterface;
use GW2ledger\Price\PriceParser;
use GW2ledger\Price\PriceFactory;
use GW2ledger\Signature\Price\PriceAssemblerInterface;

/**
 * This class is to fetch and retrieve prices
 */
class PriceAssembler implements PriceAssemblerInterface
{
  protected $webScraper;

  private $priceFactory;
  /**
   * constructor assembles the factories needed to create a new object
   */
  public function __construct(WebScraperInterface $webScraper)
  {
    $this->webScraper = $webScraper;
    $priceParser = new PriceParser();
    $this->priceFactory = new PriceFactory($priceParser);
  }

  /**
   * gets an array of prices for a particular item, optionally restrained by the number and the starting point
   * @param  int    $itemId  the id of the item that we are looking up
   * @return Price       a price objects for the item
   */
  public function getByItemId($itemId)
  {
    $url = "https://api.guildwars2.com/v2/commerce/prices/".$itemId;//this has a very simple result
    $result = $this->webScraper->getInfo($url);
    
    $price = $this->priceFactory->createFromJson($result);
    return $price;
  }
}