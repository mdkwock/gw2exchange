<?php
namespace GW2ledger\Signature\Item;

use GW2ledger\Signature\Base\FactoryInterface;
use GW2ledger\Signature\Item\ItemParserInterface;

/**
 * This interface is for creating item pieces, which are containers for all of an item's details.
 */
interface ItemPiecesFactoryInterface extends FactoryInterface
{

  /**
   * this function will return an instance of an Item
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Item
   * @return  Item      the created object
   */
  public function createFromJson($json);
}