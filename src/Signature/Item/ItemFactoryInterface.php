<?php
namespace GW2ledger\Signature\Item;

use GW2ledger\Signature\Connection\WebScraperInterface;

/**
 * This interface creates Item model objects
 */
interface ItemFactoryInterface extends FactoryInterface
{
  /** 
   * will create an item representation with all of the information using the id to find
   * @param  int     $itemId
   * @return Item            [description]
   */
  public function getById($itemId);
}