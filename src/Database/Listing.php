<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\Listing as BaseListing;
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
  /**
   * creates an object using parameters
   * @param  string $type          the value of the item detail for the item
   * @param  int    $orders        the number of different orders that are being requested
   * @param  int    $unit_price    the cost of one the listing
   * @param  int    $quantity      the number that are being traded
   * @return ItemItemDetail
   */
  public function create($type, $orders, $unit_price, $quantity)
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
    return static::create($attributes['type'], $attributes['orders'], $attributes['unit_price'], $attributes['quantity']);
  }
}
