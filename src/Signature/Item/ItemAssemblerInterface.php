<?php
namespace GW2ledger\Signature\Item;

use GW2ledger\Signature\Connection\WebScraperInterface;
use GW2ledger\Signature\Base\AssemblerInterface;

/**
 * This interface creates Item model objects
 */
interface ItemAssemblerInterface extends AssemblerInterface
{
  /** 
   * will create an item representation with all of the information using the id to find
   * @param  int|int[]   $itemIds  either an array of ids to get, or a single int id
   * @return Item[]                  the items that were requested
   */
  public function getByIds($itemIds);
}