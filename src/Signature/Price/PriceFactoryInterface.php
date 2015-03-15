<?php
namespace GW2ledger\Signature\Price;

use GW2ledger\Signature\Base\FactoryInterface;

/**
 * This interface creates Price model objects
 */
interface PriceFactoryInterface extends FactoryInterface
{
  /**
   * this function will return an instance of an Price
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Price
   * @return  Price      the created object
   */
  public function createFromJson($json);
}