<?php
namespace GW2Exchange\Signature\Base;

/**
 * This interface creates objects of any type
 * the constructor will be unique per type allowing for greater extendability
 */
interface FactoryInterface
{
  /** 
   * will create an object using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($attributes);
}