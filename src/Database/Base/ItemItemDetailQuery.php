<?php

namespace GW2ledger\Database\Base;

use \Exception;
use \PDO;
use GW2ledger\Database\ItemItemDetail as ChildItemItemDetail;
use GW2ledger\Database\ItemItemDetailQuery as ChildItemItemDetailQuery;
use GW2ledger\Database\Map\ItemItemDetailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item_item_detail' table.
 *
 *
 *
 * @method     ChildItemItemDetailQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemItemDetailQuery orderByItemDetailId($order = Criteria::ASC) Order by the item_detail_id column
 * @method     ChildItemItemDetailQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildItemItemDetailQuery groupByItemId() Group by the item_id column
 * @method     ChildItemItemDetailQuery groupByItemDetailId() Group by the item_detail_id column
 * @method     ChildItemItemDetailQuery groupByValue() Group by the value column
 *
 * @method     ChildItemItemDetailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemItemDetailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemItemDetailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemItemDetailQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildItemItemDetailQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildItemItemDetailQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildItemItemDetailQuery leftJoinItemDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemDetail relation
 * @method     ChildItemItemDetailQuery rightJoinItemDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemDetail relation
 * @method     ChildItemItemDetailQuery innerJoinItemDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemDetail relation
 *
 * @method     \GW2ledger\Database\ItemQuery|\GW2ledger\Database\ItemDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemItemDetail findOne(ConnectionInterface $con = null) Return the first ChildItemItemDetail matching the query
 * @method     ChildItemItemDetail findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemItemDetail matching the query, or a new ChildItemItemDetail object populated from the query conditions when no match is found
 *
 * @method     ChildItemItemDetail findOneByItemId(int $item_id) Return the first ChildItemItemDetail filtered by the item_id column
 * @method     ChildItemItemDetail findOneByItemDetailId(int $item_detail_id) Return the first ChildItemItemDetail filtered by the item_detail_id column
 * @method     ChildItemItemDetail findOneByValue(string $value) Return the first ChildItemItemDetail filtered by the value column *

 * @method     ChildItemItemDetail requirePk($key, ConnectionInterface $con = null) Return the ChildItemItemDetail by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemItemDetail requireOne(ConnectionInterface $con = null) Return the first ChildItemItemDetail matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemItemDetail requireOneByItemId(int $item_id) Return the first ChildItemItemDetail filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemItemDetail requireOneByItemDetailId(int $item_detail_id) Return the first ChildItemItemDetail filtered by the item_detail_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemItemDetail requireOneByValue(string $value) Return the first ChildItemItemDetail filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemItemDetail[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemItemDetail objects based on current ModelCriteria
 * @method     ChildItemItemDetail[]|ObjectCollection findByItemId(int $item_id) Return ChildItemItemDetail objects filtered by the item_id column
 * @method     ChildItemItemDetail[]|ObjectCollection findByItemDetailId(int $item_detail_id) Return ChildItemItemDetail objects filtered by the item_detail_id column
 * @method     ChildItemItemDetail[]|ObjectCollection findByValue(string $value) Return ChildItemItemDetail objects filtered by the value column
 * @method     ChildItemItemDetail[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemItemDetailQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2ledger\Database\Base\ItemItemDetailQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2ledger', $modelName = '\\GW2ledger\\Database\\ItemItemDetail', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemItemDetailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemItemDetailQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemItemDetailQuery) {
            return $criteria;
        }
        $query = new ChildItemItemDetailQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$item_id, $item_detail_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildItemItemDetail|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemItemDetailTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemItemDetailTableMap::DATABASE_NAME);
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
     * @return ChildItemItemDetail A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, item_detail_id, value FROM item_item_detail WHERE item_id = :p0 AND item_detail_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildItemItemDetail $obj */
            $obj = new ChildItemItemDetail();
            $obj->hydrate($row);
            ItemItemDetailTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildItemItemDetail|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ItemItemDetailTableMap::COL_ITEM_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @see       filterByItem()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the item_detail_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemDetailId(1234); // WHERE item_detail_id = 1234
     * $query->filterByItemDetailId(array(12, 34)); // WHERE item_detail_id IN (12, 34)
     * $query->filterByItemDetailId(array('min' => 12)); // WHERE item_detail_id > 12
     * </code>
     *
     * @see       filterByItemDetail()
     *
     * @param     mixed $itemDetailId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByItemDetailId($itemDetailId = null, $comparison = null)
    {
        if (is_array($itemDetailId)) {
            $useMinMax = false;
            if (isset($itemDetailId['min'])) {
                $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $itemDetailId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemDetailId['max'])) {
                $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $itemDetailId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $itemDetailId, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemItemDetailTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \GW2ledger\Database\Item object
     *
     * @param \GW2ledger\Database\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \GW2ledger\Database\Item) {
            return $this
                ->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \GW2ledger\Database\Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

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
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2ledger\Database\ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\GW2ledger\Database\ItemQuery');
    }

    /**
     * Filter the query by a related \GW2ledger\Database\ItemDetail object
     *
     * @param \GW2ledger\Database\ItemDetail|ObjectCollection $itemDetail The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function filterByItemDetail($itemDetail, $comparison = null)
    {
        if ($itemDetail instanceof \GW2ledger\Database\ItemDetail) {
            return $this
                ->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $itemDetail->getId(), $comparison);
        } elseif ($itemDetail instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID, $itemDetail->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItemDetail() only accepts arguments of type \GW2ledger\Database\ItemDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemDetail relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function joinItemDetail($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemDetail');

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
            $this->addJoinObject($join, 'ItemDetail');
        }

        return $this;
    }

    /**
     * Use the ItemDetail relation ItemDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2ledger\Database\ItemDetailQuery A secondary query class using the current class as primary query
     */
    public function useItemDetailQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemDetail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemDetail', '\GW2ledger\Database\ItemDetailQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItemItemDetail $itemItemDetail Object to remove from the list of results
     *
     * @return $this|ChildItemItemDetailQuery The current query, for fluid interface
     */
    public function prune($itemItemDetail = null)
    {
        if ($itemItemDetail) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ItemItemDetailTableMap::COL_ITEM_ID), $itemItemDetail->getItemId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ItemItemDetailTableMap::COL_ITEM_DETAIL_ID), $itemItemDetail->getItemDetailId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item_item_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemItemDetailTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemItemDetailTableMap::clearInstancePool();
            ItemItemDetailTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemItemDetailTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemItemDetailTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemItemDetailTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemItemDetailTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemItemDetailQuery