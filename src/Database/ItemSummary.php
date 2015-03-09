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
  /**
   * creates an object
   * @param  [type] $item_id    [description]
   * @param  [type] $buy_price  [description]
   * @param  [type] $sell_price [description]
   * @param  [type] $buy_qty    [description]
   * @param  [type] $sell_qty   [description]
   * @return [type]             [description]
   */
  public static function create($item_id, $buy_price, $sell_price, $buy_qty, $sell_qty)
  {
    $obj = new static();
    $obj->setItemId($item_id);
    $obj->setBuyPrice($buy_price);
    $obj->setSellPrice($sell_price);
    $obj->setBuyQty($buy_qty);
    $obj->setSellQty($sell_qty);
    return $obj;
  }
  
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $values  an array of the values necessary to create the object
   * @return object             the object that is created using the array
   */
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($values)
  {
    return static::create($values['item_id'], $values['buy_price'], $values['sell_price'], $values['buy_qty'], $values['sell_qty']);
  }
}
