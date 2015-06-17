<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Item\ItemParserInterface;
use GW2Exchange\Database\ItemItemDetailQuery;
use GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class ItemItemDetailFactory implements ItemPiecesFactoryInterface
{

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct()
  {
  }

  /** 
   * will create an object using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function create($itemId, $itemDetail)
  {    
    $item = ItemItemDetailQuery::create()
         ->filterByItemId($itemId)
         ->filterByItemDetail($itemDetail)
         ->findOneOrCreate();
    return $item;
  }

  /** 
   * will create an object using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($attributes)
  {
    return $this->create($attributes['itemId'],$attributes['itemDetail']);
  }
}