<?php
namespace GW2ledger\Item;

use GW2ledger\Signature\Item\ItemParserInterface;
use GW2ledger\Item\ItemDetailsArrayObject;
use GW2ledger\Signature\Item\ItemPiecesFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class ItemDetailsArrayObjectFactory implements ItemPiecesFactoryInterface
{
  protected $itemParser;

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(ItemParserInterface $ip)
  {
    $this->itemParser = $ip;
  }

  /**
   * this function will return an instance of GW2ItemInterface
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  ItemDetailsArrayObject       the created object
   */
  public function createFromJson($json)
  {
    $attributes = $this->itemParser->parseJson($json); //take the string and make it into a formatted array
    $returns = array();
    foreach($attributes as $attribute){
      $returns[$attribute['Id']] = $this->createFromArray($attribute);
    }
    return $returns;
  }


  /** 
   * will create an object using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($attributes)
  {
    $itemId = $attributes['Id'];
    $itemType = $attributes['Type'];
    //find the 'details' key
    $details = $attributes['Details'];
    //doing this so its more understandable to just look in the relevant array
    $itemDetails = new ItemDetailsArrayObject();
    $itemDetails->setAllFromArray(array('item_id'=>$itemId, 'item_type'=>$itemType, 'details'=>$details));
    return $itemDetails;
  }
}