<?php
namespace GW2Exchange\Signature\Database;

/**
 * This interface is so that we can have a factory to create our query objects rather than use propel's static method
 */
interface DatabaseQueryFactoryInterface
{
  /**
   * Creates a Propel Query object
   * @return ModelCriteria   the query object
   */
  public function createQuery();
}