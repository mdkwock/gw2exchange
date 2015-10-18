<?php
namespace GW2Exchange\Price;

use GW2Exchange\Database\Price;
use GW2Exchange\Database\PriceQuery;
use GW2Exchange\Signature\Price\PriceFactoryInterface;
use GW2Exchange\Signature\Price\PriceParserInterface;

use GW2Exchange\Log\PriceLogger;

/**
 * This class creates the Price objects
 */
class PriceFactory implements PriceFactoryInterface
{
  private $priceLogger;

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(PriceLogger $priceLogger)
  {
    $this->priceLogger = $priceLogger;
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
    $price->setPriceLogger($this->priceLogger);
    return $price;
  }
}