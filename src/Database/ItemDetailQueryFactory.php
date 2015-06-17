<?php
namespace GW2Exchange\Database;

use GW2Exchange\Database\ItemDetailQuery;
use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;

/**
 * This class is so that we can have a factory to create our query objects rather than use propel's static method
 * to allow for more testability
 */
class ItemDetailQueryFactory implements DatabaseQueryFactoryInterface
{
  /**
   * Creates a Propel Query object
   * @return ModelCriteria   the query object
   */
  public function createQuery()
  {
    return new ItemDetailQuery();
  }
}
