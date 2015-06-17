<?php
namespace GW2Exchange\Database;

use GW2Exchange\Signature\Database\DatabaseObjectInterface;

interface ItemDetailInterface extends DatabaseObjectInterface
{
  public function getLabel();

  public function getItemType();

  public function setLabel($value);

  public function setItemType($value);
}
