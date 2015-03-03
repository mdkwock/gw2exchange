<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\Item as BaseItem;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

/**
 * Skeleton subclass for representing a row from the 'item' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Item extends BaseItem implements DatabaseObjectInterface
{
  public function __construct($id, $name, $icon)
  {
    $this->setId($id);
    $this->setName($name);
    $this->setIcon($icon);
  }

  /**
   * creates an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public static function create($attributes)
  {
    $obj = new static($attributes['id'], $attributes['name'], $attributes['icon']);
    return $obj;
  }
}
