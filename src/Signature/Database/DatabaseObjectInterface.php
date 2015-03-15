<?php
namespace GW2ledger\Signature\Database;

/**
 * This interface is so that we can guarantee that there is a create method for the propel objects
 */
interface DatabaseObjectInterface
{
  /**
   * sets all of the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($attributes);

  /**
   * this function saves the object into storage
   * @return [type] [description]
   */
  public function save();
}