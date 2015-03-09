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
  /**
   * creates an object
   * @param  string $value          the value of the item detail for the item
   * @param  int    $item_id        the id of the item
   * @param  int    $item_detail_id the id of the item_detail
   * @return ItemItemDetail
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
   * @return object             the object that is created using the array
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
