<?php
namespace GW2Exchange\Signature\Database;

/**
 * This interface is so that we can guarantee that there is a create method for the propel objects
 */
interface DatabaseObjectInterface
{
  /**
   * this function is used as a shortcut to the propel table mapping process
   * will return an array of all of the columns that are controlled by this object
   * @return string[]     all of the fields that this object has
   */
  public function getFields();

  /**
   * sets all of the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($attributes);

  
  /**
   * Retrieves a field from the object by name passed in as a string.
   *
   * @param      string $name name
   * @param      string $type The type of fieldname the $name is of:
   *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
   *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
   *                     Defaults to TableMap::TYPE_PHPNAME.
   * @return mixed Value of field.
   */
  public function getByName($name, $type);

  /**
   * gets an array representation for json and easy output handling
   * @return array 
   */
  public function toArray();

  /**
   * this function saves the object into storage
   * @return [type] [description]
   */
  public function save();
}