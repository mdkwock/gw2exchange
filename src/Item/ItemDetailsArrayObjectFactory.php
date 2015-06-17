<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Item\ItemParserInterface;
use GW2Exchange\Item\ItemDetailsArrayObject;
use GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class ItemDetailsArrayObjectFactory implements ItemPiecesFactoryInterface
{
  protected $itemDetailFactory;
  protected $itemItemDetailFactory;

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(ItemDetailFactory $itemDetailFactory, ItemItemDetailFactory $itemItemDetailFactory)
  {
    $this->itemDetailFactory = $itemDetailFactory;
    $this->itemItemDetailFactory = $itemItemDetailFactory;
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
    $details = empty($attributes['Details'])?array():$attributes['Details'];
    //doing this so its more understandable to just look in the relevant array
    $itemDetails = new ItemDetailsArrayObject($this->itemDetailFactory, $this->itemItemDetailFactory);
    $itemDetails->setAllFromArray(array('item_id'=>$itemId, 'item_type'=>$itemType, 'details'=>$details));
    return $itemDetails;
  }
}