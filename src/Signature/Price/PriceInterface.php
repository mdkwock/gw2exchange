<?php
namespace GW2ledger\Signature\Price;

use GW2ledger\Signature\Database\DatabaseObjectInterface;

/**
 * This interface is a facade to simplify the Price hooks
 */
interface PriceInterface extends DatabaseObjectInterface
{

  /**
   * sets the info of an attribute based on the provided key
   * @param string  $key     the label of the attribute
   * @param mixed   $value   the value that we are setting
   */
  public function setByName($name,$value);
}