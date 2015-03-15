<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\ItemDetail as BaseItemDetail;
use GW2ledger\Database\Map\ItemDetailTableMap;
use GW2ledger\Database\ItemDetailInterface;

/**
 * Skeleton subclass for representing a row from the 'item_detail' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ItemDetail extends BaseItemDetail implements ItemDetailInterface
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
      $baseItemTable = ItemDetailTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * This function sets all of the values of an Item using the parameters given
   * @param  string $item_type the type of item determines which details are available
   * @param  string $label     the name of the value key
   */
  public function setAll($item_type, $label,$value_type=null)
  {
    $this->setItemType($item_type);
    $this->setLabel($label);
    if(!empty($value_type)){
      $this->setValueType($value_type);
    }

  }

  /**
   * sets all the attributes for an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   */
  public function setAllFromArray($values)
  {
    if(!array_key_exists('value_type', $values)){
      //force the value type to exist bc otherwise they'll be errors
      $values['value_type'] = null;
    }
    return $this->setAll($values['item_type'],$values['label'],$values['value_type']);
  }
}
