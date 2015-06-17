<?php
namespace GW2Exchange\Price;

use GW2Exchange\Database\Price;
use GW2Exchange\Database\PriceQuery;
use GW2Exchange\Signature\Price\PriceFactoryInterface;
use GW2Exchange\Signature\Price\PriceParserInterface;

/**
 * This class creates the Price objects
 */
class PriceFactory implements PriceFactoryInterface
{

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct()
  {
  }

  /** 
   * will create a single Price using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($arr)
  {
    $price = PriceQuery::create()->filterByItemId($arr['ItemId'])->findOneOrCreate();
    $price->setAllFromArray($arr);
    return $price;
  }
}