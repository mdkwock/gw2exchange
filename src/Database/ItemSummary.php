<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\ItemSummary as BaseItemSummary;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

/**
 * Skeleton subclass for representing a row from the 'item_summary' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ItemSummary extends BaseItemSummary implements DatabaseObjectInterface
{
  public function __construct($item_id, $buy_price, $sell_price, $buy_qty, $sell_qty)
  {
    $this->item_id = $item_id;
    $this->buy_price = $buy_price;
    $this->sell_price = $sell_price;
    $this->buy_qty = $buy_qty;
    $this->sell_qty = $sell_qty;
  }
  
  /**
   * creates an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public static function create($attributes)
  {
    
  }
}
