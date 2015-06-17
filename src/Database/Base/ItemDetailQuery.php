<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\ItemDetail as ChildItemDetail;
use GW2Exchange\Database\ItemDetailQuery as ChildItemDetailQuery;
use GW2Exchange\Database\Map\ItemDetailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item_detail' table.
 *
 *
 *
 * @method     ChildItemDetailQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildItemDetailQuery orderByItemType($order = Criteria::ASC) Order by the item_type column
 * @method     ChildItemDetailQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildItemDetailQuery orderByValueType($order = Criteria::ASC) Order by the value_type column
 *
 * @method     ChildItemDetailQuery groupById() Group by the id column
 * @method     ChildItemDetailQuery groupByItemType() Group by the item_type column
 * @method     ChildItemDetailQuery groupByLabel() Group by the label column
 * @method     ChildItemDetailQuery groupByValueType() Group by the value_type column
 *
 * @method     ChildItemDetailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemDetailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemDetailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemDetailQuery leftJoinItemItemDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemItemDetail relation
 * @method     ChildItemDetailQuery rightJoinItemItemDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemItemDetail relation
 * @method     ChildItemDetailQuery innerJoinItemItemDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemItemDetail relation
 *
 * @method     \GW2Exchange\Database\ItemItemDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemDetail findOne(ConnectionInterface $con = null) Return the first ChildItemDetail matching the query
 * @method     ChildItemDetail findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemDetail matching the query, or a new ChildItemDetail object populated from the query conditions when no match is found
 *
 * @method     ChildItemDetail findOneById(int $id) Return the first ChildItemDetail filtered by the id column
 * @method     ChildItemDetail findOneByItemType(string $item_type) Return the first ChildItemDetail filtered by the item_type column
 * @method     ChildItemDetail findOneByLabel(string $label) Return the first ChildItemDetail filtered by the label column
 * @method     ChildItemDetail findOneByValueType(string $value_type) Return the first ChildItemDetail filtered by the value_type column *

 * @method     ChildItemDetail requirePk($key, ConnectionInterface $con = null) Return the ChildItemDetail by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemDetail requireOne(ConnectionInterface $con = null) Return the first ChildItemDetail matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemDetail requireOneById(int $id) Return the first ChildItemDetail filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemDetail requireOneByItemType(string $item_type) Return the first ChildItemDetail filtered by the item_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemDetail requireOneByLabel(string $label) Return the first ChildItemDetail filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemDetail requireOneByValueType(string $value_type) Return the first ChildItemDetail filtered by the value_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemDetail[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemDetail objects based on current ModelCriteria
 * @method     ChildItemDetail[]|ObjectCollection findById(int $id) Return ChildItemDetail objects filtered by the id column
 * @method     ChildItemDetail[]|ObjectCollection findByItemType(string $item_type) Return ChildItemDetail objects filtered by the item_type column
 * @method     ChildItemDetail[]|ObjectCollection findByLabel(string $label) Return ChildItemDetail objects filtered by the label column
 * @method     ChildItemDetail[]|ObjectCollection findByValueType(string $value_type) Return ChildItemDetail objects filtered by the value_type column
 * @method     ChildItemDetail[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemDetailQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\ItemDetailQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2exchange', $modelName = '\\GW2Exchange\\Database\\ItemDetail', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemDetailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemDetailQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemDetailQuery) {
            return $criteria;
        }
        $query = new ChildItemDetailQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildItemDetail|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemDetailTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemDetailTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemDetail A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, item_type, label, value_type FROM item_detail WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildItemDetail $obj */
            $obj = new ChildItemDetail();
            $obj->hydrate($row);
            ItemDetailTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildItemDetail|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemDetailTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemDetailTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ItemDetailTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ItemDetailTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemDetailTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the item_type column
     *
     * Example usage:
     * <code>
     * $query->filterByItemType('fooValue');   // WHERE item_type = 'fooValue'
     * $query->filterByItemType('%fooValue%'); // WHERE item_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByItemType($itemType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemType)) {
                $itemType = str_replace('*', '%', $itemType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemDetailTableMap::COL_ITEM_TYPE, $itemType, $comparison);
    }

    /**
     * Filter the query on the label column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
     * $query->filterByLabel('%fooValue%'); // WHERE label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $label)) {
                $label = str_replace('*', '%', $label);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemDetailTableMap::COL_LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the value_type column
     *
     * Example usage:
     * <code>
     * $query->filterByValueType('fooValue');   // WHERE value_type = 'fooValue'
     * $query->filterByValueType('%fooValue%'); // WHERE value_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $valueType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByValueType($valueType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($valueType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $valueType)) {
                $valueType = str_replace('*', '%', $valueType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemDetailTableMap::COL_VALUE_TYPE, $valueType, $comparison);
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\ItemItemDetail object
     *
     * @param \GW2Exchange\Database\ItemItemDetail|ObjectCollection $itemItemDetail the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByItemItemDetail($itemItemDetail, $comparison = null)
    {
        if ($itemItemDetail instanceof \GW2Exchange\Database\ItemItemDetail) {
            return $this
                ->addUsingAlias(ItemDetailTableMap::COL_ID, $itemItemDetail->getItemDetailId(), $comparison);
        } elseif ($itemItemDetail instanceof ObjectCollection) {
            return $this
                ->useItemItemDetailQuery()
                ->filterByPrimaryKeys($itemItemDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemItemDetail() only accepts arguments of type \GW2Exchange\Database\ItemItemDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemItemDetail relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function joinItemItemDetail($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemItemDetail');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ItemItemDetail');
        }

        return $this;
    }

    /**
     * Use the ItemItemDetail relation ItemItemDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2Exchange\Database\ItemItemDetailQuery A secondary query class using the current class as primary query
     */
    public function useItemItemDetailQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemItemDetail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemItemDetail', '\GW2Exchange\Database\ItemItemDetailQuery');
    }

    /**
     * Filter the query by a related Item object
     * using the item_item_detail table as cross reference
     *
     * @param Item $item the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemDetailQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useItemItemDetailQuery()
            ->filterByItem($item, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItemDetail $itemDetail Object to remove from the list of results
     *
     * @return $this|ChildItemDetailQuery The current query, for fluid interface
     */
    public function prune($itemDetail = null)
    {
        if ($itemDetail) {
            $this->addUsingAlias(ItemDetailTableMap::COL_ID, $itemDetail->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemDetailTableMap::clearInstancePool();
            ItemDetailTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemDetailTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemDetailTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemDetailTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemDetailQuery
