<?php
namespace GW2ledger\Signature\Item;

use \GW2ledger\Signature\Item\ItemParserInterface;
/**
 * This interface is the Item object class facade
 */
interface ItemInfoFactoryInterface
{
  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(ItemParserInterface $ip);

  /**
   * this function will return an instance of GW2ItemInterface
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  GW2ItemInterface       the created object
   */
  public function createFromJson($json);
}