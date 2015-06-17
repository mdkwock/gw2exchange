<?php
namespace GW2ledger\Item;

use \GW2ledger\Signature\Connection\WebScraperInterface;
use \GW2ledger\Signature\Item\ItemAssemblerInterface;
use \GW2ledger\Item\ItemParser;
use \GW2ledger\Item\BaseItemFactory;
use \GW2ledger\Item\ItemInfoFactory;
use \GW2ledger\Item\ItemDetailsObjectFactory;
use \GW2ledger\Item\Item;

/**
 * This interface creates Item model objects
 */
class ItemAssembler implements ItemAssemblerInterface
{
  protected $webScraper;

  private $itemParser;
  private $baseItemFactory;
  private $itemInfoFactory;
  private $itemDetailsFactory;

  /**
   * constructor assembles the factories needed to create a new object
   */
  public function __construct(WebScraperInterface $webScraper)
  {
    $this->webScraper = $webScraper;
    $this->itemParser = new ItemParser();
    $this->itemFactory = new BaseItemFactory($this->itemParser);
    $this->itemInfoFactory = new ItemInfoFactory($this->itemParser);
    $this->itemDetailsFactory = new ItemDetailsArrayObjectFactory($this->itemParser);
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
    if(is_array($itemIds)){
      //if it's an array
      $itemId = implode(",", $itemIds);
    }elseif(is_numeric($itemIds)){
      //if it looks like a number id
      $itemId = intval($itemIds);
    }
    $url = "https://api.guildwars2.com/v2/items?ids=".$itemId;//this has a very simple result
    $result = $this->webScraper->getInfo($url);
    $arrResult = $this->itemParser->parseJson($result);
    $return = array();
    //we do the same parsing bc it doesn't matter whether it was single or multiple bc we go to the same endpoint
    foreach($arrResult as $attributes){
      //make an item for each item requested
      $baseItem = $this->itemFactory->createFromArray($attributes);
      $itemInfo = $this->itemInfoFactory->createFromArray($attributes);
      $itemDetails = $this->itemDetailsFactory->createFromArray($attributes);
      $item = new Item($baseItem, $itemInfo, $itemDetails);
      $return[$attributes['Id']] = $item;
    }
    return $return;
  }
}