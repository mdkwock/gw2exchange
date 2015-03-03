<?php
namespace GW2ledger\Item;

use GW2ledger\Signature\Item\ItemParserInterface;
use GW2ledger\Database\ItemInfo;
use GW2ledger\Signature\Item\ItemInfoFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class ItemInfoFactory implements ItemInfoFactoryInterface
{
  protected $itemParser;

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(ItemParserInterface $ip)
  {
    $this->itemParser = $ip;
  }

  /**
   * this function will return an instance of GW2ItemInterface
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  GW2ItemInterface       the created object
   */
  public function createFromJson($json)
  {
    $attributes = $this->itemParser->parseJson($json); //take the string and make it into a formatted array
    $itemInfo = ItemInfo::create($attributes);
    return $itemInfo;
  }
}