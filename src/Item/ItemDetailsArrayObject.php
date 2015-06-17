<?php
namespace GW2ledger\Item;

use GW2ledger\Signature\Item\ItemDetailsObjectInterface;
use GW2ledger\Database\ItemDetailQuery;
use GW2ledger\Database\ItemItemDetailQuery;
use GW2ledger\Database\ItemItemDetail;
use GW2ledger\Database\Map\ItemItemDetailTableMap as TableMap;

/**
 * This class assembles a ItemDetail object which simplifies usage, uses an array implementation
 */
class ItemDetailsArrayObject implements ItemDetailsObjectInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '';

  //a array of ['itemDetailLabel'] => itemItemDetail
  protected $data;

  /**
   * this function is used as a shortcut to the propel table mapping process
   * will return an array of all of the columns that are controlled by this object
   * @return string[]     all of the fields that this object has
   */
  public function getFields()
  {
    return array_map('strtolower', array_keys($this->data));
  }
  
  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function setAll($itemId, $itemType, $details)
  {
    $this->data = array();
    foreach($details as $detailLabel=>$detailValue){
      //look for an existing item detail or create a new one so we dont duplicate
      $itemDetail = ItemDetailQuery::create()
       ->filterByItemType($itemType)
       ->filterByLabel($detailLabel)
       ->findOneOrCreate();
      $itemDetail->setAllFromArray(array('item_type'=>$itemType, 'label'=>$detailLabel));
      if($itemDetail->isNew()){
        //if the detail attribute has not been created before
        //save it so that we know one exists if we look a second time
        //this shouldn't really get called them that often
        $itemDetail->save();
        $itemItemDetail = new ItemItemDetail();
      }else{
        //only check if a detail already exists if the item detail existed before
        $itemItemDetail = ItemItemDetailQuery::create()
         ->filterByItemId($itemId)
         ->filterByItemDetail($itemDetail)
         ->findOneOrCreate();
      }
      $itemItemDetail->setAllFromArray(array('value'=>$detailValue));
      $itemItemDetail->setItemId($itemId);
      $itemItemDetail->setItemDetail($itemDetail);
      $this->data[$detailLabel] = $itemItemDetail;
    }
  }


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
  public function getByName($name, $type = null)
  {
    if(!empty($this->data[$name])){
      $detail = $this->data[$name];
      return $detail->getValue();
    }else{
      return null;
    }
  }

  public function setAllFromArray($attributes)
  {
    $this->setAll($attributes['item_id'],$attributes['item_type'],$attributes['details']);
  }

  /**
   * gets an associative array representation of the details
   * @return string[]     the keys are the keys and the values are the corresponding values
   */
  public function getArray()
  {
    $arr = array();
    foreach($this->data as $key=>$detail){
      $arr[$key] = $detail->getValue();
    }
    return $arr;
  }

  /**
   * sets the value of a key if defined, true if success, false if not saved because the key doesn't exist, Exception if failure
   * @throws Exception //if there was a technical error saving to the database
   * @param string $key    the key we are saving to 
   * @param mixed $value   the value we are trying to save
   * @return boolean       whether the save was successful
   */
  public function setValue($key,$value)
  {
    $detail = $this->data[$key];
    $detail->setValue($value);
  }

  /**
   * saves the details onto the server
   * @return [type] [description]
   */
  public function save()
  {
    foreach($this->data as $detail)
    {

 //     $itemItemDetail->setItemDetail($itemDetail);
      $detail->save();

    }
  }
}