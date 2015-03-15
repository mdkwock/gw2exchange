<?php
namespace GW2ledger\Item;

use \GW2ledger\Signature\Connection\WebScraperInterface;
use \GW2ledger\Item\ItemParser;
use \GW2ledger\Item\BaseItemFactory;
use \GW2ledger\Item\ItemInfoFactory;
use \GW2ledger\Item\ItemDetailsObjectFactory;
use \GW2ledger\Item\Item;

/**
 * This interface creates Item model objects
 */
class ItemFactory
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
   * will create an item representation with all of the information using the id to find
   * @param  int     $itemId
   * @return Item            [description]
   */
  public function getById($itemId)
  {
    $url = "https://api.guildwars2.com/v2/items/".$itemId;//this has a very simple result
    $result = $this->webScraper->getInfo($url);
    
    $baseItem = $this->itemFactory->createFromJson($result);
    $itemInfo = $this->itemInfoFactory->createFromJson($result);
    $itemDetails = $this->itemDetailsFactory->createFromJson($result);
    $item = new Item($baseItem, $itemInfo, $itemDetails);
    return $item;
  }
}