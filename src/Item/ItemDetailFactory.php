<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Item\ItemParserInterface;
use GW2Exchange\Database\ItemDetailQuery as ItemDetailQuery;
use GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
/**
 * This class assembles a GW2Item
 */
class ItemDetailFactory implements ItemPiecesFactoryInterface
{

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct()
  {
  }

  /**
   * create a new item detail
   * @param  string $itemType       the type of item this is
   * @param  string $detailLabel    the label of this item detail
   * @return ItemDetail              
   */
  public function create($itemType, $detailLabel)
  {
    $item = ItemDetailQuery::create()
       ->filterByItemType($itemType)
       ->filterByLabel($detailLabel)
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
    return $this->create($attributes['ItemType'],$attributes['DetailLabel']);
  }
}