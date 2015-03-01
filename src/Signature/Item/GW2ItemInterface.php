<?php
namespace GW2ledger\Signature\Item;

/**
 * This interface assembles a GW2Item
 */
interface GW2ItemInterface
{
  /**
   * saves the item to a data store
   * @throws Exception   if save failed
   * @return 
   */
  public function save();
}