<?php

namespace Base;

use \ItemSummary as ChildItemSummary;
use \ItemSummaryQuery as ChildItemSummaryQuery;
use \Exception;
use \PDO;
use Map\ItemSummaryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item_summary' table.
 *
 *
 *
 * @method     ChildItemSummaryQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemSummaryQuery orderByBuyPrice($order = Criteria::ASC) Order by the buy_price column
 * @method     ChildItemSummaryQuery orderBySellPrice($order = Criteria::ASC) Order by the sell_price column
 * @method     ChildItemSummaryQuery orderByBuyQty($order = Criteria::ASC) Order by the buy_qty column
 * @method     ChildItemSummaryQuery orderBySellQty($order = Criteria::ASC) Order by the sell_qty column
 *
 * @method     ChildItemSummaryQuery groupByItemId() Group by the item_id column
 * @method     ChildItemSummaryQuery groupByBuyPrice() Group by the buy_price column
 * @method     ChildItemSummaryQuery groupBySellPrice() Group by the sell_price column
 * @method     ChildItemSummaryQuery groupByBuyQty() Group by the buy_qty column
 * @method     ChildItemSummaryQuery groupBySellQty() Group by the sell_qty column
 *
 * @method     ChildItemSummaryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemSummaryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemSummaryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemSummaryQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildItemSummaryQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildItemSummaryQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     \ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemSummary findOne(ConnectionInterface $con = null) Return the first ChildItemSummary matching the query
 * @method     ChildItemSummary findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemSummary matching the query, or a new ChildItemSummary object populated from the query conditions when no match is found
 *
 * @method     ChildItemSummary findOneByItemId(int $item_id) Return the first ChildItemSummary filtered by the item_id column
 * @method     ChildItemSummary findOneByBuyPrice(int $buy_price) Return the first ChildItemSummary filtered by the buy_price column
 * @method     ChildItemSummary findOneBySellPrice(int $sell_price) Return the first ChildItemSummary filtered by the sell_price column
 * @method     ChildItemSummary findOneByBuyQty(int $buy_qty) Return the first ChildItemSummary filtered by the buy_qty column
 * @method     ChildItemSummary findOneBySellQty(int $sell_qty) Return the first ChildItemSummary filtered by the sell_qty column *

 * @method     ChildItemSummary requirePk($key, ConnectionInterface $con = null) Return the ChildItemSummary by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemSummary requireOne(ConnectionInterface $con = null) Return the first ChildItemSummary matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemSummary requireOneByItemId(int $item_id) Return the first ChildItemSummary filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemSummary requireOneByBuyPrice(int $buy_price) Return the first ChildItemSummary filtered by the buy_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemSummary requireOneBySellPrice(int $sell_price) Return the first ChildItemSummary filtered by the sell_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemSummary requireOneByBuyQty(int $buy_qty) Return the first ChildItemSummary filtered by the buy_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemSummary requireOneBySellQty(int $sell_qty) Return the first ChildItemSummary filtered by the sell_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemSummary[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemSummary objects based on current ModelCriteria
 * @method     ChildItemSummary[]|ObjectCollection findByItemId(int $item_id) Return ChildItemSummary objects filtered by the item_id column
 * @method     ChildItemSummary[]|ObjectCollection findByBuyPrice(int $buy_price) Return ChildItemSummary objects filtered by the buy_price column
 * @method     ChildItemSummary[]|ObjectCollection findBySellPrice(int $sell_price) Return ChildItemSummary objects filtered by the sell_price column
 * @method     ChildItemSummary[]|ObjectCollection findByBuyQty(int $buy_qty) Return ChildItemSummary objects filtered by the buy_qty column
 * @method     ChildItemSummary[]|ObjectCollection findBySellQty(int $sell_qty) Return ChildItemSummary objects filtered by the sell_qty column
 * @method     ChildItemSummary[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemSummaryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ItemSummaryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2ledger', $modelName = '\\ItemSummary', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemSummaryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemSummaryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemSummaryQuery) {
            return $criteria;
        }
        $query = new ChildItemSummaryQuery();
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
     * @return ChildItemSummary|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemSummaryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemSummaryTableMap::DATABASE_NAME);
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
     * @return ChildItemSummary A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, buy_price, sell_price, buy_qty, sell_qty FROM item_summary WHERE item_id = :p0';
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
            /** @var ChildItemSummary $obj */
            $obj = new ChildItemSummary();
            $obj->hydrate($row);
            ItemSummaryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItemSummary|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the buy_price column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyPrice(1234); // WHERE buy_price = 1234
     * $query->filterByBuyPrice(array(12, 34)); // WHERE buy_price IN (12, 34)
     * $query->filterByBuyPrice(array('min' => 12)); // WHERE buy_price > 12
     * </code>
     *
     * @param     mixed $buyPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterByBuyPrice($buyPrice = null, $comparison = null)
    {
        if (is_array($buyPrice)) {
            $useMinMax = false;
            if (isset($buyPrice['min'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_BUY_PRICE, $buyPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyPrice['max'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_BUY_PRICE, $buyPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemSummaryTableMap::COL_BUY_PRICE, $buyPrice, $comparison);
    }

    /**
     * Filter the query on the sell_price column
     *
     * Example usage:
     * <code>
     * $query->filterBySellPrice(1234); // WHERE sell_price = 1234
     * $query->filterBySellPrice(array(12, 34)); // WHERE sell_price IN (12, 34)
     * $query->filterBySellPrice(array('min' => 12)); // WHERE sell_price > 12
     * </code>
     *
     * @param     mixed $sellPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterBySellPrice($sellPrice = null, $comparison = null)
    {
        if (is_array($sellPrice)) {
            $useMinMax = false;
            if (isset($sellPrice['min'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_SELL_PRICE, $sellPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellPrice['max'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_SELL_PRICE, $sellPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemSummaryTableMap::COL_SELL_PRICE, $sellPrice, $comparison);
    }

    /**
     * Filter the query on the buy_qty column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyQty(1234); // WHERE buy_qty = 1234
     * $query->filterByBuyQty(array(12, 34)); // WHERE buy_qty IN (12, 34)
     * $query->filterByBuyQty(array('min' => 12)); // WHERE buy_qty > 12
     * </code>
     *
     * @param     mixed $buyQty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterByBuyQty($buyQty = null, $comparison = null)
    {
        if (is_array($buyQty)) {
            $useMinMax = false;
            if (isset($buyQty['min'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_BUY_QTY, $buyQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyQty['max'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_BUY_QTY, $buyQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemSummaryTableMap::COL_BUY_QTY, $buyQty, $comparison);
    }

    /**
     * Filter the query on the sell_qty column
     *
     * Example usage:
     * <code>
     * $query->filterBySellQty(1234); // WHERE sell_qty = 1234
     * $query->filterBySellQty(array(12, 34)); // WHERE sell_qty IN (12, 34)
     * $query->filterBySellQty(array('min' => 12)); // WHERE sell_qty > 12
     * </code>
     *
     * @param     mixed $sellQty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterBySellQty($sellQty = null, $comparison = null)
    {
        if (is_array($sellQty)) {
            $useMinMax = false;
            if (isset($sellQty['min'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_SELL_QTY, $sellQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellQty['max'])) {
                $this->addUsingAlias(ItemSummaryTableMap::COL_SELL_QTY, $sellQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemSummaryTableMap::COL_SELL_QTY, $sellQty, $comparison);
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemSummaryQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
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
     * @return \ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItemSummary $itemSummary Object to remove from the list of results
     *
     * @return $this|ChildItemSummaryQuery The current query, for fluid interface
     */
    public function prune($itemSummary = null)
    {
        if ($itemSummary) {
            $this->addUsingAlias(ItemSummaryTableMap::COL_ITEM_ID, $itemSummary->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item_summary table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemSummaryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemSummaryTableMap::clearInstancePool();
            ItemSummaryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemSummaryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemSummaryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemSummaryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemSummaryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemSummaryQuery
