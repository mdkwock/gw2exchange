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
  public function __construct($type, $orders, $unit_price, $quantity)
  { 
    $this->type = $type;
    $this->orders = $orders;
    $this->unit_price = $unit_price;
    $this->quantity = $quantity;
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
