<?php

namespace GW2Exchange\Taxes;

class TaxService
{
  /**
   * returns the listing tax amount, minimum of 1c
   * @param  int $sellPrice    the amount that the item is getting sold for
   * @return int               the amount of the tax
   */
  public static function getListTax($sellPrice){
    $tax =  round($sellPrice*.05);//tax is 5% of the sell price
    return $tax>1?$tax:1;
  } 

  /**
   * returns the listing tax amount, minimum of 1c
   * @param  int $sellPrice    the amount that the item is getting sold for
   * @return int               the amount of the tax
   */
  public static function getSoldTax($sellPrice){
    $tax =  round($sellPrice*.1);//tax is 10% of the sell price
    return $tax>1?$tax:1;
  }

  /**
   * returns the amount of gold after all taxes taken out
   * @param  int $sellPrice    the amount that the item is getting sold for
   * @return int               the amount of the tax
   */
  public static function applyTaxes($sellPrice){
    $list = static::getListTax($sellPrice);
    $sold = static::getSoldTax($sellPrice);
    $net = $sellPrice - $list - $sold;
    return $net;
  }
}