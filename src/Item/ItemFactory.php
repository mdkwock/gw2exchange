<?php
namespace GW2Exchange\Item;

use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;

use \GW2Exchange\Item\Item;
/**
 * This class assembles a GW2Item
 * This implementation of Factory is a bit different because it is not creating an object that has it's own properties
 * rather it is creating a container that will hold the
 */
class ItemFactory implements ItemFactoryInterface
{

  private $baseItemFactory;
  private $itemInfoFactory;
  private $ItemPiecesFactory;

  /**
   * creates an object using the 3 parts
   * @param ItemPiecesFactoryInterface  $baseItemFactory    
   * @param ItemPiecesFactoryInterface  $itemInfoFactory    
   * @param ItemPiecesFactoryInterface  $itemDetailsFactory
   */
  public function __construct(ItemPiecesFactoryInterface $baseItemFactory,
      ItemPiecesFactoryInterface $itemInfoFactory, ItemPiecesFactoryInterface $itemPiecesFactory)
  {
    $this->baseItemFactory = $baseItemFactory;
    $this->itemInfoFactory = $itemInfoFactory;
    $this->itemPiecesFactory = $itemPiecesFactory;
    //map all the attributes for each table
  }

  /** 
   * will create an object using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($attributes)
  {
    $baseItem = $this->baseItemFactory->createFromArray($attributes);
    $itemInfo = $this->itemInfoFactory->createFromArray($attributes);
    $itemDetails = $this->itemPiecesFactory->createFromArray($attributes);
    $item = new Item($baseItem, $itemInfo, $itemDetails);
    return $item;
  }
}