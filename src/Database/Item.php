<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\Item as BaseItem;
use GW2ledger\Database\Map\ItemTableMap;
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
      $baseItemTable = ItemTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * This function sets all of the values of an Item using the parameters given
   * @param  int     $id          the id of the item as given by GW2 server
   * @param  string  $name        the name of the item
   * @param  string  $icon        the icon of the item
   */
  public function setAll($id, $name, $icon)
  {
    $this->setId($id);
    $this->setName($name);
    $this->setIcon($icon);
    return $this;    
  }

  /**
   * sets all the attributes for an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   */
  public function setAllFromArray($attributes)
  {
    return $this->setAll($attributes['Id'],$attributes['Name'],$attributes['Icon']);
  }
}
