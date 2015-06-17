<?php
namespace GW2ledger\Item;

use GW2ledger\Signature\Item\ItemParserInterface;
use GW2ledger\Database\ItemQuery as DBItemQuery;
use GW2ledger\Signature\Item\ItemPiecesFactoryInterface;

/**
 * This class assembles a GW2Item
 */
class BaseItemFactory implements ItemPiecesFactoryInterface
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
   * @return  Item            the created object
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
    $item = DBItemQuery::create()->filterById($attributes['Id'])->findOneOrCreate();
    $item->setAllFromArray($attributes);
    return $item;
  }
}