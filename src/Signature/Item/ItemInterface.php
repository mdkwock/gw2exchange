<?php
namespace GW2Exchange\Signature\Item;

use GW2Exchange\Signature\Database\DatabaseObjectInterface;

/**
 * This interface is a facade to simplify the Item hooks
 */
interface ItemInterface extends DatabaseObjectInterface
{

  /**
   * sets the info of an attribute based on the provided key
   * @param string  $key     the label of the attribute
   * @param mixed   $value   the value that we are setting
   */
  public function setByName($name,$value);
}