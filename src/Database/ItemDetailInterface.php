<?php
namespace GW2ledger\Database;

use GW2ledger\Signature\Database\DatabaseObjectInterface;

interface ItemDetailInterface extends DatabaseObjectInterface
{
  public function getLabel();

  public function getItemType();

  public function setLabel($value);

  public function setItemType($value);
}
