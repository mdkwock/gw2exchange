<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\ItemDetail as BaseItemDetail;
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
  /**
   * creates a new instance using parameters
   * @param  string $item_type the type of item determines which details are available
   * @param  string $label     the name of the value key
   * @return ItemDetail
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
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
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
