<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Item\ItemParserInterface;
use GW2Exchange\Database\ItemInfoQuery;
use GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class ItemInfoFactory implements ItemPiecesFactoryInterface
{

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct()
  {
  }

  public function createFromArray($attributes)
  {
    if(empty($attributes['Id'])){
      //if we dont know the Id (big trouble but not really relevant)
      $itemInfo = ItemInfoQuery::create()->filterByItemId(null)->findOneOrCreate();
    }else{
      //we have an id
      $itemInfo = ItemInfoQuery::create()->filterByItemId($attributes['Id'])->findOneOrCreate();
    }    
    $itemInfo->setAllFromArray($attributes);
    return $itemInfo;
  }
}