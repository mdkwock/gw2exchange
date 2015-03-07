<?php
namespace GW2ledger\Signature\Database;

/**
 * This interface is so that we can guarantee that there is a create method for the propel objects
 */
interface DatabaseObjectInterface
{
  /**
   * creates an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public static function createFromArray($attributes);

  /**
   * this function saves the object into storage
   * @return [type] [description]
   */
  public function save();
}