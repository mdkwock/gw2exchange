<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\ItemItemDetail as BaseItemItemDetail;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

/**
 * Skeleton subclass for representing a row from the 'item_item_detail' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ItemItemDetail extends BaseItemItemDetail implements DatabaseObjectInterface
{
  public function __construct($item_id, $item_detail_id, $value)
  {
    $this->item_id = $item_id;
    $this->item_detail_id = $item_detail_id;
    $this->value = $value;
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
