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

  /**
   * This function creates an Item using the parameters given
   * @param  int     $id          the id of the item as given by GW2 server
   * @param  string  $name        the name of the item
   * @param  string  $icon        the icon of the item
   * @return Item
   */
  public static function create($id, $name, $icon)
  {
    $obj = new static();
    $obj->setId($id);
    $obj->setName($name);
    $obj->setIcon($icon);
    return $obj;    
  }

  /**
   * creates an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return Item             the object that is created using the array
   */
  public static function createFromArray($attributes)
  {
    return static::create($attributes['id'],$attributes['name'],$attributes['icon']);
  }
}
