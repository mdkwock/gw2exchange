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
  private $listingParser;
  /**
   * constructor assembles the factories needed to create a new object
   */
  public function __construct(WebScraperInterface $webScraper)
  {
    $this->webScraper = $webScraper;
    $this->listingParser = new ListingParser();
    $this->listingFactory = new ListingFactory($this->listingParser);
  }

  /**
   * returns a list of item ids, the ones listed are the ones with current listings available
   * @return int[]
   */
  public function getIdList()
  {
    $url = "https://api.guildwars2.com/v2/commerce/listings/";
    $result = $this->webScraper->getInfo($url);
    $result = $this->listingParser->parseList($result);
    return $result;
  }

  /**
   * gets an array of listings for a particular item, optionally restrained by the number and the starting point
   * @param  int|int[]    $itemIds  the id of the item that we are looking up
   * @param  int    $count   the number of listings we are returning, -1 means all of them
   * @param  int    $start   the number of listings that we are skipping
   * @return Listing[][]       an matrix of listing objects for the item where the first key is the item key
   */
  public function getByItemIds($itemIds, $count = -1, $start = 0)
  {
    if(is_array($itemIds)){
      //if they passed more than one id in
      $itemId = implode(",", $itemIds);
    }elseif(is_numeric($itemIds)){
      //if it looks like a number id
      $itemId = intval($itemIds);
    }
    if($count == 0){
      //idk why you would request 0 but if you do, just skip the whole thing
      return [];
    }
    $url = "https://api.guildwars2.com/v2/commerce/listings?ids=".$itemId;//this has a very simple result
    $result = $this->webScraper->getInfo($url);
    
    $return = array();//this is the matrix that gets returned by the function
    $temps = $this->listingFactory->createManyFromJson($result);
    foreach($temps as $id=>$temp){
      if($count === -1){
        $return[$id] = $temp;
      }else{
        $return[$id] = array_slice($temp, $start, $count);
      }      
    }
    return $return;  
  }
}