<?php
namespace GW2ledger\Listing;

use \GW2ledger\Signature\Connection\WebScraperInterface;
use GW2ledger\Listing\ListingParser;
use GW2ledger\Listing\ListingFactory;
use GW2ledger\Signature\Listing\ListingAssemblerInterface;

/**
 * This class is to fetch and retrieve listings
 */
class ListingAssembler implements ListingAssemblerInterface
{
  protected $webScraper;

  private $listingFactory;
  /**
   * constructor assembles the factories needed to create a new object
   */
  public function __construct(WebScraperInterface $webScraper)
  {
    $this->webScraper = $webScraper;
    $listingParser = new ListingParser();
    $this->listingFactory = new ListingFactory($listingParser);
  }

  /**
   * gets an array of listings for a particular item, optionally restrained by the number and the starting point
   * @param  int    $itemId  the id of the item that we are looking up
   * @param  int    $count   the number of listings we are returning, -1 means all of them
   * @param  int    $start   the number of listings that we are skipping
   * @return Listing[]       an array of listing objects for the item
   */
  public function getByItemId($itemId, $count = -1, $start = 0)
  {
    if($count == 0){
      //idk why you would request 0 but if you do, just skip the whole thing
      return [];
    }
    $url = "https://api.guildwars2.com/v2/commerce/listings/".$itemId;//this has a very simple result
    $result = $this->webScraper->getInfo($url);
    
    $listings = $this->listingFactory->createManyFromJson($result);
    if($count === -1){
      return $listings;
    }else{
      return array_slice($listings, $start, $count);
    }      
  }
}