<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\Price as BasePrice;
use GW2ledger\Database\Map\PriceTableMap;
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
class Price extends BasePrice implements DatabaseObjectInterface
{
  protected static $tableColumnMap;

  /**
   * this function is used as a shortcut to the propel table mapping process
   * will return an array of all of the columns that are controlled by this object
   * @return string[]     all of the fields that this object has
   */
  public function getFields()
  {
    if(empty(static::$tableColumnMap)){
      //if we have not already generated a map
      $baseItemTable = PriceTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * sets all the fields an object
   * @param  [type] $item_id    [description]
   * @param  [type] $buy_price  [description]
   * @param  [type] $sell_price [description]
   * @param  [type] $buy_qty    [description]
   * @param  [type] $sell_qty   [description]
   * @return [type]             [description]
   */
  public function setAll($item_id, $buy_price, $sell_price, $buy_qty, $sell_qty)
  {
    $this->setItemId($item_id);
    $this->setBuyPrice($buy_price);
    $this->setSellPrice($sell_price);
    $this->setBuyQty($buy_qty);
    $this->setSellQty($sell_qty);
  }
  
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($values)
  {
    return $this->setAll($values['ItemId'], $values['BuyPrice'], $values['SellPrice'], $values['BuyQty'], $values['SellQty']);
  }
}
