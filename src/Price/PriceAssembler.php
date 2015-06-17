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
  private $priceParser;
  /**
   * constructor assembles the factories needed to create a new object
   */
  public function __construct(WebScraperInterface $webScraper)
  {
    $this->webScraper = $webScraper;
    $this->priceParser = new PriceParser();
    $this->priceFactory = new PriceFactory($this->priceParser);
  }

  /**
   * returns a list of item ids, the ones listed are the ones with current listings available
   * @return int[]
   */
  public function getIdList()
  {
    $url = "https://api.guildwars2.com/v2/commerce/listings/";
    $result = $this->webScraper->getInfo($url);
    $result = $this->priceParser->parseList($result);
    return $result;
  }

  /**
   * gets an array of prices for a particular item, optionally restrained by the number and the starting point
   * @param  int|int[]    $itemIds  the ids of the item that we are looking up
   * @return Price[]       a price objects for each of the items
   */
  public function getByItemIds($itemIds)
  {
    if(is_array($itemIds)){
      $itemId = implode(",", $itemIds);
    }elseif(is_numeric($itemIds)){
      //if it looks like a number id
      $itemId = intval($itemIds);
    }
    $url = "https://api.guildwars2.com/v2/commerce/prices?ids=".$itemId;//this has a very simple result
    $result = $this->webScraper->getInfo($url);
    
    $price = $this->priceFactory->createFromJson($result);
    return $price;
  }
}