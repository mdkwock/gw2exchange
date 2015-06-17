<?php
namespace GW2Exchange\Signature\Item;

use GW2Exchange\Signature\Database\DatabaseObjectInterface;
/**
 * This interface is for the item's details. it provides an easier to reason interface rather than dealing directly with the database model.
 * Allows the two tables to be hidden rather than deal with the issues of handling the detail and the value
 */
interface ItemDetailsObjectInterface extends DatabaseObjectInterface
{
  /**
   * creates an object using an array of attributes
   * @param  object  $item      the item which we 
   * @param  string  $type      the type of the item
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAll($item, $type,$attributes);

  /**
   * sets the value of a key if defined, true if success, false if not saved because the key doesn't exist, Exception if failure
   * @throws Exception //if there was a technical error saving to the database
   * @param string $key    the key we are saving to 
   * @param mixed $value   the value we are trying to save
   * @return boolean       whether the save was successful
   */
  public function setValue($key,$value);
}