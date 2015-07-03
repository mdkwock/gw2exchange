<?php
namespace GW2Exchange\Database;

use GW2Exchange\Database\Base\Item as BaseItem;
use GW2Exchange\Database\Map\ItemTableMap;
use GW2Exchange\Signature\Database\DatabaseObjectInterface;
use Propel\Runtime\Connection\ConnectionInterface;
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
  protected $minCacheTime = 1;

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

  public function toArray($keyType = ItemTableMap::TYPE_COLNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
  {

    //if we have already dumped this object, indicated that its already been done and we're stopping
    if (isset($alreadyDumpedObjects['Item'][$this->hashCode()])) {
        return '*RECURSION*';
    }
    $keyType = ItemTableMap::TYPE_PHPNAME;
    $result = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);
    //assign the related object index keys
    //use keys variables rather than setting string constants so that it will work no matter how it is being called
    switch($keyType){
      default:
      case ItemTableMap::TYPE_PHPNAME:
        $itemKey = 'Item';
        $itemInfoKey = 'ItemInfo';
        $itemItemDetailKey = 'ItemItemDetails';
        $itemDetailKey = 'Details';
        $itemDetail = 'ItemDetail';
        $itemDetailLabelKey = 'Label';
        $itemDetailValueKey = 'Value';
      break;
      case ItemTableMap::TYPE_CAMELNAME:
        $itemKey = 'item';
        $itemInfoKey = 'itemInfo';
        $itemItemDetailKey = 'itemItemDetails';
        $itemDetailKey = 'details';
        $itemDetail = 'itemDetail';
        $itemDetailLabelKey = 'label';
        $itemDetailValueKey = 'value';
      break;
      case ItemTableMap::TYPE_COLNAME:
        $itemKey = 'Item';
        $itemInfoKey = 'ItemInfo';
        $itemItemDetailKey = 'ItemItemDetails';
        $itemDetailKey = 'Details';
        $itemDetail = 'ItemDetail';
        $itemDetailLabelKey = 'item_detail.label';
        $itemDetailValueKey = 'item_item_detail.value';
      break;
      case ItemTableMap::TYPE_FIELDNAME:
        $itemKey = 'item';
        $itemInfoKey = 'item_info';
        $itemItemDetailKey = 'item_item_details';
        $itemDetailKey = 'details';
        $itemDetail = 'item_detail';
        $itemDetailLabelKey = 'label';
        $itemDetailValueKey = 'value';
      break;
      case ItemTableMap::TYPE_NUM:
        $itemKey = 'Item';
        $itemInfoKey = 'ItemInfo';
        $itemItemDetailKey = 'ItemItemDetails';
        $itemDetailKey = 'details';
        $itemDetail = 'ItemDetail';
        $itemDetailLabelKey = '2';
        $itemDetailValueKey = '2';
      break;
    }
    //move the item's info into the root
    //dd($keyType);
    $itemInfo = $this->getItemInfo();
    if(!empty($itemInfo)){
      $itemInfoArray = $itemInfo->toArray();
      $result = array_merge($result, $itemInfoArray);
    }    
    /*
    $itemInfo = $result[$itemInfoKey];
    unset($itemInfo[$itemKey]);//unset the recursive entry
    unset($result[$itemInfoKey]);
  */

    //reformat the details
    $details = array();
    $itemItemDetails = $this->getItemItemDetails();
    foreach ($itemItemDetails as $itemItemDetail) {
      $value = $itemItemDetail->getValue();
      $itemDetail = $itemItemDetail->getItemDetail();
      $itemDetailLabel = $itemDetail->getLabel();
      $details[$itemDetailLabel] = $value;
    }

    /*
    foreach($result[$itemItemDetailKey] as $itemItemDetail){
      dd($itemItemDetail);

      $itemDetail = $itemItemDetail[$itemDetail][$itemDetailLabelKey];
      $details[$itemDetailKey] = $itemItemDetail[$itemDetailValueKey];
    }
    */
    $result[$itemDetailKey] = $details;
    unset($result[$itemItemDetailKey]);
    return $result;
  }

  public function hash(){
    $data = $this->toArray();
    $hash = md5(json_encode($data));
    return $hash;
  }

  /**
   * Code to be run before persisting the object
   * Creates a Price History Record of the previous value and saves it to the db
   * @param  ConnectionInterface $con
   * @return boolean
   */
  public function preSave(ConnectionInterface $con =  null)
  {
    $newHash = $this->hash();//calculate the hash values of the new object
    //if the old hash value and this new hash value are the same, then the object is the same
    if($this->getHash() == $newHash){
      $this->setCacheTime($this->getCacheTime()*2);//double the cache time
    }else{
      $this->setCacheTime($this->minCacheTime);//else reset the cache time to the minimum
    }
    $this->setHash($newHash);
    return true;
  }
}
