<?php
namespace GW2Exchange\Signature\Base;

/**
 * This interface is to provide a nice and easy method for retrieving objects
 */
interface AssemblerInterface
{
  /**
   * returns a list of ids of some type
   * @return int[]
   */
  public function getIdList();

  /**
   * creates a new object out of the passed in array of attributes
   * @param  array  $attributes  an associative array of the attributes for the object
   * @return Object              the resulting object
   */
  public function createFromArray($attributes);
}