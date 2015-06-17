<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Item\ItemParserInterface;
use GW2Exchange\Database\ItemQuery as DBItemQuery;
use GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class BaseItemFactory implements ItemPiecesFactoryInterface
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
  public function createFromArray($attributes)
  {
    try{
      $item = DBItemQuery::create()->filterById($attributes['Id'])->findOneOrCreate();
      $item->setAllFromArray($attributes);
      return $item;
    }catch(\Exception $e){
      d($e);
      d(DBItemQuery::create()->filterById($attributes['Id'])->toString());
      dd($attributes);
    }
  }
}