<?php
namespace GW2ledger\Signature\Item;

use GW2ledger\Signature\Database\DatabaseObjectInterface;

/**
 * This interface is a facade to simplify the Listing hooks
 */
interface ListingInterface extends DatabaseObjectInterface
{
  /**
   * sets the info of an attribute based on the provided key
   * @param string  $key     the label of the attribute
   * @param mixed   $value   the value that we are setting
   */
  public function setByName($name,$value);
}