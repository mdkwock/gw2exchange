<?php
namespace GW2ledger\Signature\Item;

use \GW2ledger\Signature\Item\ItemParserInterface;
/**
 * This interface creates Item model objects
 */
interface ItemFactoryInterface
{
  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(ItemParserInterface $ip);

  /**
   * this function will return an instance of GW2ItemInterface
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  Item      the created object
   */
  public function createFromJson($json);
}