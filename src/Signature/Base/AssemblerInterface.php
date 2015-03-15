<?php
namespace GW2ledger\Signature\Base;

/**
 * This interface is to provide a nice and easy method for retrieving objects
 */
interface AssemblerInterface
{
  /**
   * returns a list of ids of some type
   * @return int[]
   */
  public function getList();
}