<?php
namespace GW2Exchange\Item;

use \GW2Exchange\Signature\Item\ItemInterface;
use \GW2Exchange\Database\Item as BaseItem;
use \GW2Exchange\Database\ItemInfo;
use \GW2Exchange\Signature\Item\ItemDetailsObjectInterface;
use \GW2Exchange\Signature\Database\DatabaseObjectInterface;
use Propel\Runtime\Map\TableMap;

/**
 * This class is a facade to simplify the Item hooks
 */
class Item implements ItemInterface
{
  private $baseItem;
  private $itemInfo;
  private $itemDetails;
  //this variable is so that we dont need to do a full lookup each time
  //but we still dont need to explicitly map each attribute
  private $attributeMap;

  /**
   * creates an object using the 3 parts
   * @param [type] $baseItem    [description]
   * @param [type] $itemInfo    [description]
   * @param [type] $itemDetails [description]
   */
  public function __construct(DatabaseObjectInterface $baseItem,DatabaseObjectInterface $itemInfo,ItemDetailsObjectInterface $itemDetails)
  {
    $this->baseItem = $baseItem;
    $this->itemInfo = $itemInfo;
    $this->itemDetails = $itemDetails;
    //$this->baseItem->setItemInfo($this->itemInfo);
    //$this->itemDetails->setItem($this->baseItem);
    //map all the attributes for each table
  }

  /**
   * gets an array of every attribute that are contained in the item
   * @return  string[]         an array of strings with the labels of the item attributes
   */
  public function getFields()
  {
    if(empty($this->attributeMap)){
      //cache the attributes so we dont need to lookup everytime
      $itemFields = $this->baseItem->getFields();
      $itemInfoFields = $this->itemInfo->getFields();
      $itemDetailsFields = $this->itemDetails->getFields();
      $this->attributeMap = array(
        "baseItem"=>$itemFields,
        "itemInfo"=>$itemInfoFields,
        "itemDetails"=>$itemDetailsFields);
    }
    //mash all the fields into a single array so we hide implementation
    $fields = array_merge($this->attributeMap['baseItem'],$this->attributeMap['itemInfo'],$this->attributeMap['itemDetails']);
    return $fields;
  }

  /**
   * gets the requested information based on the key
   * can't use individual function for each attribute because then the details object would be different
   * and we want to hide all that complexity
   * @param  string  $key  the name of the attribute we are getting
   * @return mixed         the value of that attribute
   */
  public function getByName($name,$type = null)
  {
    if(empty($this->attributeMap)){
      //if we have not figured out what attributes we have, then find out so we dont have to try each one
      $this->getFields();
    }
    foreach($this->attributeMap as $object=>$fields)
    {
      if(array_search($name,$fields) !== false){
        //if the object we are looking at has the field name
        return $this->$object->getByName($name);
      }  
    }
    return null;
  }

  /**
   * sets the info of an attribute based on the provided key
   * @param string  $key     the label of the attribute
   * @param mixed   $value   the value that we are setting
   */
  public function setByName($name,$value)
  {
    if(empty($this->attributeMap)){
      //if we have not figured out what attributes we have, then find out so we dont have to try each one
      $this->getFields();
    }
    foreach($this->attributeMap as $object=>$fields)
    {
      if(array_search($name,$fields) !== false){
        //if the object we are looking at has the field name
        $this->$object->setByName($name,$value);
      }  
    }    
  }


  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($values)
  {
    //calls the setall command on each element with the entire array, letting each component deal with the selecting and storing
    $this->baseItem->setAllFromArray($values);
    $this->itemInfo->setAllFromArray($values);
    $this->itemDetails->setAllFromArray($values);
  }

  /**
   * gets an array representation for json and easy output handling
   * @return array 
   */
  public function toArray()
  {
    $base = $this->baseItem->toArray(TableMap::TYPE_PHPNAME);
    return $base;
  }

  /**
   * this function creates a hash of the data contained in this object, to allow for quick checks of whether or not the object has been updated
   * @return [type] [description]
   */
  public function hash($arr = array()){
    if(empty($arr)){
      $arr = $this->toArray();  
    }    
    $hash = md5(json_encode($arr));
    return $hash;
  }

  public function save()
  {
    //calls the save command on each element, letting each component deal with saving
    $this->baseItem->save();
    $this->itemInfo->save();
    $this->itemDetails->save();
  }
}