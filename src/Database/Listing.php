<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\Listing as BaseListing;
use GW2ledger\Database\Map\ListingTableMap;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

/**
 * Skeleton subclass for representing a row from the 'listing' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Listing extends BaseListing implements DatabaseObjectInterface
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
      $baseItemTable = ListingTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * sets all of the attributes of an object using parameters
   * @param  string $type          the value of the item detail for the item
   * @param  int    $orders        the number of different orders that are being requested
   * @param  int    $unit_price    the cost of one the listing
   * @param  int    $quantity      the number that are being traded
   * @return ItemItemDetail
   */
  public function setAll($type, $orders, $unit_price, $quantity)
  { 
    $obj = new static();
    $obj->setType($type);
    $obj->setOrders($orders);
    $obj->setUnitPrice($unit_price);
    $obj->setQuantity($quantity);
    return $obj;
  }
  
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($attributes)
  {
    $this->setAll($attributes['Type'], $attributes['Orders'], $attributes['UnitPrice'], $attributes['Quantity']);
  }
}
