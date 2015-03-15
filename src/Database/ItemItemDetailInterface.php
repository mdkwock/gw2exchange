<?php
namespace GW2ledger\Database;

use GW2ledger\Signature\Database\DatabaseObjectInterface;

interface ItemItemDetailInterface extends DatabaseObjectInterface
{
  public function getValue();

  public function getItem();

  public function getItemDetail();

  public function setValue();

  public function setItem();

  public function setItemDetail();
}
