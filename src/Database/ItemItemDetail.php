<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\ItemItemDetail as BaseItemItemDetail;
use GW2ledger\Database\Map\ItemItemDetailTableMap;
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
      $baseItemTable = ItemItemDetailTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * sets all the attributes of an object
   * @param  string $value          the value of the item detail for the item
   * @param  int    $item_id        the id of the item
   * @param  int    $item_detail_id the id of the item_detail
   */
  public function setAll($value,$item_id=null,$item_detail_id=null)
  {
    if(!empty($item_id)){
      $this->setItemId($item_id);
    }
    if(!empty($item_detail_id)){
      $this->setItemDetailId($item_detail_id);
    }
    //we arent sure what we're getting so serialize it always
    $this->setValue($value);
  }
  
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   */
  public function setAllFromArray($values)
  {
    if(!array_key_exists('item_id', $values)){
      //if the item is not passed
      $values['item_id'] = null;//prevent it from erroring out
    }
    if(!array_key_exists('item_detail_id', $values)){
      //if the item detail is not passed
      $values['item_detail_id'] = null;//prevent it from erroring out
    }
    return $this->setAll($values['value'],$values['item_id'],$values['item_detail_id']);
  }

  public function getValue()
  {
    return unserialize(parent::getValue());
  }

  public function setValue($value)
  {
    parent::setValue(serialize($value));
  }
}
