<?php
namespace GW2Exchange\Price;

use \GW2Exchange\Signature\Connection\WebScraperInterface;
use GW2Exchange\Price\PriceParser;
use GW2Exchange\Price\PriceFactory;
use GW2Exchange\Signature\Price\PriceAssemblerInterface;

use GuzzleHttp\Exception\ClientException;

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
  public function __construct(WebScraperInterface $webScraper, PriceParser $priceParser, PriceFactory $priceFactory)
  {
    $this->webScraper = $webScraper;
    $this->priceParser = $priceParser;
    $this->priceFactory = $priceFactory;
  }

  /**
   * returns a list of item ids, the ones listed are the ones with current prices available
   * @return int[]
   */
  public function getIdList()
  {
    $url = "https://api.guildwars2.com/v2/commerce/prices/";
    $result = $this->webScraper->getInfo($url);
    $result = $this->priceParser->parseList($result);
    return $result;
  }

  /**
   * gets the price for a particular item
   * @param  int|int[]    $itemIds  the ids of the items that we are looking up
   * @return Price[]       a price objects for each of the items
   */
  public function getByItemIds($itemIds)
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
    $url = "https://api.guildwars2.com/v2/commerce/prices?ids=".$itemId;//this has a very simple result
    try{
      $json = $this->webScraper->getInfo($url);
      $objs = $this->priceParser->parseJson($json); //take the string and make it into a formatted array
    }catch(ClientException $e){
      if($e->getCode() == 404){
        //if the item doesn't exist
        return array();//return an empty array
      }else{
        throw $e;//else pass the error up
      }
    }

    $prices = array();
    foreach ($objs as $attributes) {
      $prices[] = $this->createFromArray($attributes);
    }    
    return $prices;
  }
  

  public function createFromArray($attributes)
  {
    //we do the same parsing bc it doesn't matter whether it was single or multiple bc we go to the same endpoint
    //so that the format is always the same
    $return = $this->priceFactory->createFromArray($attributes);
    return $return;    
  }

  /**
   * this function will return a single instance of an Price
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Price
   * @return  Price      the created object
   */
  public function createFromJson($json)
  {
    $objs = $this->priceParser->parseJson($json); //take the string and make it into a formatted array
    return $this->createFromArray($objs);
  }
}