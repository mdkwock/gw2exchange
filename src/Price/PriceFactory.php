<?php
namespace GW2ledger\Price;

use GW2ledger\Database\PriceQuery;
use GW2ledger\Signature\Price\PriceFactoryInterface;
use GW2ledger\Signature\Price\PriceParserInterface;

/**
 * This class creates the Price objects
 */
class PriceFactory implements PriceFactoryInterface
{
  protected $priceParser;

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(PriceParserInterface $lp)
  {
    $this->priceParser = $lp;
  }

  /** 
   * will create a single Price using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($arr)
  {
    $price = PriceQuery::create()
       ->filterByItemId($arr['ItemId'])
       ->findOneOrCreate();
    $price->setAllFromArray($arr);
    return $price;
  }

  /**
   * this function will return a single instance of an Price
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Price
   * @return  Price      the created object
   */
  public function createFromJson($json)
  {
    $objs = $this->priceParser->parseJson($json); //take the string and make it into a formatted array
    $returns = array();
    foreach($objs as $attribute){
      $returns[$attribute['ItemId']] = $this->createFromArray($attribute);
    }
    return $returns;
  }
}