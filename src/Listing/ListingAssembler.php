<?php
namespace GW2Exchange\Listing;

use \GW2Exchange\Signature\Connection\WebScraperInterface;
use GW2Exchange\Listing\ListingParser;
use GW2Exchange\Listing\ListingFactory;
use GW2Exchange\Signature\Listing\ListingAssemblerInterface;

use GuzzleHttp\Exception\ClientException;

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
  public function __construct(WebScraperInterface $webScraper, ListingParser $listingParser, ListingFactory $listingFactory)
  {
    $this->webScraper = $webScraper;
    $this->listingParser = $listingParser;
    $this->listingFactory = $listingFactory;
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
      //if it's an array
      if(count($itemIds)>200){
        //cap the number of ids given at 200
        $itemIds = array_slice($itemIds,0,200);
      }
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
    try{
      $result = $this->webScraper->getInfo($url);
    }catch(ClientException $e){
      if($e->getCode() == 404){
        //if the item doesn't exist
        return array();//return an empty array
      }else{
        throw $e;//else pass the error up
      }
    }
    $return = array();//this is the matrix that gets reJturned by the function
    $temps = $this->createFromJson($result);
    foreach($temps as $id=>$temp){
      //for each item limit the results sent back
      if($count === -1){
        $return[] = $temp;
      }else{
        $return[] = array_slice($temp, $start, $count);
      }      
    }
    return $return;  
  }


  /**
   * creates a set of listings from an array of listings data
   * @param  string[] $array  an array which has all of the info to create a set of listings
   * @return Listing[]        the set of listings represented by the data
   */
  public function createFromArray($array)
  {
    $results = array();
    foreach($array as $obj)
    {
      $results[] = $this->listingFactory->createFromArray($obj);
    }
    return $results;
  }

  /**
   * creates a set of listings from a json string of listings data
   *
   * this will probably be the one that is used the most
   * @param  string $json  an json string which has all of the info to create a set of listings
   * @return Listing[]        the set of listings represented by the data
   */
  public function createFromJson($json)
  {
    $objs = $this->listingParser->parseJson($json); //take the string and make it into a formatted array
    $returns = array();
    foreach($objs as $itemList){
      //for every item get all of the listings associated
      $temp = $this->createFromArray($itemList);
      $itemId = reset($itemList)['ItemId'];//get the item id from the first listing
      $returns[] = $temp;
    }
    return $returns;
  }
}