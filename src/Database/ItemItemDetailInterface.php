<?php
namespace GW2Exchange\Database;

use GW2Exchange\Signature\Database\DatabaseObjectInterface;

interface ItemItemDetailInterface extends DatabaseObjectInterface
{
  public function getValue();

  public function getItem();

  public function getItemDetail();

  public function setValue();

  public function setItem();

  public function setItemDetail();
}
