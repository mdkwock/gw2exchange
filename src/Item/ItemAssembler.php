<?php
namespace GW2Exchange\Item;

use \GW2Exchange\Signature\Connection\WebScraperInterface;
use \GW2Exchange\Signature\Item\ItemAssemblerInterface;
use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \GW2Exchange\Item\ItemParser;

use GuzzleHttp\Exception\ClientException;

/**
 * This class retrieves Item model objects
 */
class ItemAssembler implements ItemAssemblerInterface
{
  protected $webScraper;

  private $itemParser;
  private $baseItemFactory;
  private $itemInfoFactory;
  private $itemPiecesFactory;
  private $itemFactory;

  /**
   * constructor assembles the factories needed to create a new object
   */
  public function __construct(WebScraperInterface $webScraper, ItemParser $itemParser, ItemFactoryInterface $itemFactory)
  {
    $this->webScraper = $webScraper;
    $this->itemParser = $itemParser;
    $this->itemFactory = $itemFactory;
  }

  /**
   * returns a list of all item ids
   * @return int[]
   */
  public function getIdList()
  {
    $url = "https://api.guildwars2.com/v2/items/";
    $result = $this->webScraper->getInfo($url);
    $result = $this->itemParser->parseList($result);
    return $result;
  }

  /** 
   * will create an item representation with all of the information using the id to find
   * @param  int|int[]   $itemIds  either an array of ids to get, or a single int id
   * @return Item[]                  the items that were requested
   */
  public function getByIds($itemIds)
  {
    if(empty($itemIds)){
      //if there arent any ids passed to the function 
      return array();
    }elseif(is_array($itemIds)){
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

    //get item from database
    //and check if the time updated is less than cache + now
    //if true then ask server for update
    //if the server hands the same object back, then double the cache time
    //else reset the cache time

    $url = "https://api.guildwars2.com/v2/items?ids=".$itemId;//this has a very simple result
    try{//try catch just in case we ask for an item that doesn't exist
      $result = $this->webScraper->getInfo($url);
    }catch(ClientException $e){
      if($e->getCode() == 404){
        //if the item doesn't exist
        return array();//return an empty array
      }else{
        throw $e;//else pass the error up
      }
    }
    return $this->createFromJson($result);
  }

  /**
   * creates a new object out of the passed in array of attributes
   * @param  array  $attributes  an associative array of the attributes for the object
   * @return Object              the resulting object
   */
  public function createFromArray($array)
  {
    //we do the same parsing bc it doesn't matter whether it was single or multiple bc we go to the same endpoint
    //so that the format is always the same
    $return = array();
    foreach($array as $attributes){
      //make an item for each item requested
      $item = $this->itemFactory->createFromArray($attributes);
      $return[] = $item;
    }
    return $return;    
  }

  /**
   * this function will return an instance of an GW2Exchange\Item\Item
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  ItemDetailsArrayObject       the created object
   */
  public function createFromJson($json)
  {
    $arrResult = $this->itemParser->parseJson($json);
    return $this->createFromArray($arrResult);
  }
}