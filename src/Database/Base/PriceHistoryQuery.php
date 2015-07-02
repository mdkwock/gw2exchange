<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\PriceHistory as ChildPriceHistory;
use GW2Exchange\Database\PriceHistoryQuery as ChildPriceHistoryQuery;
use GW2Exchange\Database\Map\PriceHistoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'price_history' table.
 *
 *
 *
 * @method     ChildPriceHistoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPriceHistoryQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildPriceHistoryQuery orderByBuyPrice($order = Criteria::ASC) Order by the buy_price column
 * @method     ChildPriceHistoryQuery orderBySellPrice($order = Criteria::ASC) Order by the sell_price column
 * @method     ChildPriceHistoryQuery orderByBuyQty($order = Criteria::ASC) Order by the buy_qty column
 * @method     ChildPriceHistoryQuery orderBySellQty($order = Criteria::ASC) Order by the sell_qty column
 * @method     ChildPriceHistoryQuery orderByProfit($order = Criteria::ASC) Order by the profit column
 * @method     ChildPriceHistoryQuery orderByRoi($order = Criteria::ASC) Order by the roi column
 * @method     ChildPriceHistoryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildPriceHistoryQuery groupById() Group by the id column
 * @method     ChildPriceHistoryQuery groupByItemId() Group by the item_id column
 * @method     ChildPriceHistoryQuery groupByBuyPrice() Group by the buy_price column
 * @method     ChildPriceHistoryQuery groupBySellPrice() Group by the sell_price column
 * @method     ChildPriceHistoryQuery groupByBuyQty() Group by the buy_qty column
 * @method     ChildPriceHistoryQuery groupBySellQty() Group by the sell_qty column
 * @method     ChildPriceHistoryQuery groupByProfit() Group by the profit column
 * @method     ChildPriceHistoryQuery groupByRoi() Group by the roi column
 * @method     ChildPriceHistoryQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildPriceHistoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPriceHistoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPriceHistoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPriceHistoryQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildPriceHistoryQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildPriceHistoryQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildPriceHistoryQuery leftJoinPrice($relationAlias = null) Adds a LEFT JOIN clause to the query using the Price relation
 * @method     ChildPriceHistoryQuery rightJoinPrice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Price relation
 * @method     ChildPriceHistoryQuery innerJoinPrice($relationAlias = null) Adds a INNER JOIN clause to the query using the Price relation
 *
 * @method     \GW2Exchange\Database\ItemQuery|\GW2Exchange\Database\PriceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPriceHistory findOne(ConnectionInterface $con = null) Return the first ChildPriceHistory matching the query
 * @method     ChildPriceHistory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPriceHistory matching the query, or a new ChildPriceHistory object populated from the query conditions when no match is found
 *
 * @method     ChildPriceHistory findOneById(int $id) Return the first ChildPriceHistory filtered by the id column
 * @method     ChildPriceHistory findOneByItemId(int $item_id) Return the first ChildPriceHistory filtered by the item_id column
 * @method     ChildPriceHistory findOneByBuyPrice(int $buy_price) Return the first ChildPriceHistory filtered by the buy_price column
 * @method     ChildPriceHistory findOneBySellPrice(int $sell_price) Return the first ChildPriceHistory filtered by the sell_price column
 * @method     ChildPriceHistory findOneByBuyQty(int $buy_qty) Return the first ChildPriceHistory filtered by the buy_qty column
 * @method     ChildPriceHistory findOneBySellQty(int $sell_qty) Return the first ChildPriceHistory filtered by the sell_qty column
 * @method     ChildPriceHistory findOneByProfit(int $profit) Return the first ChildPriceHistory filtered by the profit column
 * @method     ChildPriceHistory findOneByRoi(double $roi) Return the first ChildPriceHistory filtered by the roi column
 * @method     ChildPriceHistory findOneByCreatedAt(string $created_at) Return the first ChildPriceHistory filtered by the created_at column *

 * @method     ChildPriceHistory requirePk($key, ConnectionInterface $con = null) Return the ChildPriceHistory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOne(ConnectionInterface $con = null) Return the first ChildPriceHistory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPriceHistory requireOneById(int $id) Return the first ChildPriceHistory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneByItemId(int $item_id) Return the first ChildPriceHistory filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneByBuyPrice(int $buy_price) Return the first ChildPriceHistory filtered by the buy_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneBySellPrice(int $sell_price) Return the first ChildPriceHistory filtered by the sell_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneByBuyQty(int $buy_qty) Return the first ChildPriceHistory filtered by the buy_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneBySellQty(int $sell_qty) Return the first ChildPriceHistory filtered by the sell_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneByProfit(int $profit) Return the first ChildPriceHistory filtered by the profit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneByRoi(double $roi) Return the first ChildPriceHistory filtered by the roi column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceHistory requireOneByCreatedAt(string $created_at) Return the first ChildPriceHistory filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPriceHistory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPriceHistory objects based on current ModelCriteria
 * @method     ChildPriceHistory[]|ObjectCollection findById(int $id) Return ChildPriceHistory objects filtered by the id column
 * @method     ChildPriceHistory[]|ObjectCollection findByItemId(int $item_id) Return ChildPriceHistory objects filtered by the item_id column
 * @method     ChildPriceHistory[]|ObjectCollection findByBuyPrice(int $buy_price) Return ChildPriceHistory objects filtered by the buy_price column
 * @method     ChildPriceHistory[]|ObjectCollection findBySellPrice(int $sell_price) Return ChildPriceHistory objects filtered by the sell_price column
 * @method     ChildPriceHistory[]|ObjectCollection findByBuyQty(int $buy_qty) Return ChildPriceHistory objects filtered by the buy_qty column
 * @method     ChildPriceHistory[]|ObjectCollection findBySellQty(int $sell_qty) Return ChildPriceHistory objects filtered by the sell_qty column
 * @method     ChildPriceHistory[]|ObjectCollection findByProfit(int $profit) Return ChildPriceHistory objects filtered by the profit column
 * @method     ChildPriceHistory[]|ObjectCollection findByRoi(double $roi) Return ChildPriceHistory objects filtered by the roi column
 * @method     ChildPriceHistory[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPriceHistory objects filtered by the created_at column
 * @method     ChildPriceHistory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PriceHistoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\PriceHistoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2exchange', $modelName = '\\GW2Exchange\\Database\\PriceHistory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPriceHistoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPriceHistoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPriceHistoryQuery) {
            return $criteria;
        }
        $query = new ChildPriceHistoryQuery();
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
     * @return ChildPriceHistory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PriceHistoryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PriceHistoryTableMap::DATABASE_NAME);
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
     * @return ChildPriceHistory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, item_id, buy_price, sell_price, buy_qty, sell_qty, profit, roi, created_at FROM price_history WHERE id = :p0';
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
            /** @var ChildPriceHistory $obj */
            $obj = new ChildPriceHistory();
            $obj->hydrate($row);
            PriceHistoryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPriceHistory|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PriceHistoryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PriceHistoryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_ID, $id, $comparison);
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
     * @see       filterByPrice()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $itemId, $comparison);
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
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByBuyPrice($buyPrice = null, $comparison = null)
    {
        if (is_array($buyPrice)) {
            $useMinMax = false;
            if (isset($buyPrice['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_BUY_PRICE, $buyPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyPrice['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_BUY_PRICE, $buyPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_BUY_PRICE, $buyPrice, $comparison);
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
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterBySellPrice($sellPrice = null, $comparison = null)
    {
        if (is_array($sellPrice)) {
            $useMinMax = false;
            if (isset($sellPrice['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_SELL_PRICE, $sellPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellPrice['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_SELL_PRICE, $sellPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_SELL_PRICE, $sellPrice, $comparison);
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
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByBuyQty($buyQty = null, $comparison = null)
    {
        if (is_array($buyQty)) {
            $useMinMax = false;
            if (isset($buyQty['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_BUY_QTY, $buyQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyQty['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_BUY_QTY, $buyQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_BUY_QTY, $buyQty, $comparison);
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
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterBySellQty($sellQty = null, $comparison = null)
    {
        if (is_array($sellQty)) {
            $useMinMax = false;
            if (isset($sellQty['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_SELL_QTY, $sellQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellQty['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_SELL_QTY, $sellQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_SELL_QTY, $sellQty, $comparison);
    }

    /**
     * Filter the query on the profit column
     *
     * Example usage:
     * <code>
     * $query->filterByProfit(1234); // WHERE profit = 1234
     * $query->filterByProfit(array(12, 34)); // WHERE profit IN (12, 34)
     * $query->filterByProfit(array('min' => 12)); // WHERE profit > 12
     * </code>
     *
     * @param     mixed $profit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByProfit($profit = null, $comparison = null)
    {
        if (is_array($profit)) {
            $useMinMax = false;
            if (isset($profit['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_PROFIT, $profit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profit['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_PROFIT, $profit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_PROFIT, $profit, $comparison);
    }

    /**
     * Filter the query on the roi column
     *
     * Example usage:
     * <code>
     * $query->filterByRoi(1234); // WHERE roi = 1234
     * $query->filterByRoi(array(12, 34)); // WHERE roi IN (12, 34)
     * $query->filterByRoi(array('min' => 12)); // WHERE roi > 12
     * </code>
     *
     * @param     mixed $roi The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByRoi($roi = null, $comparison = null)
    {
        if (is_array($roi)) {
            $useMinMax = false;
            if (isset($roi['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_ROI, $roi['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roi['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_ROI, $roi['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_ROI, $roi, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PriceHistoryTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceHistoryTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\Item object
     *
     * @param \GW2Exchange\Database\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \GW2Exchange\Database\Item) {
            return $this
                ->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \GW2Exchange\Database\Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * @return \GW2Exchange\Database\ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\GW2Exchange\Database\ItemQuery');
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\Price object
     *
     * @param \GW2Exchange\Database\Price|ObjectCollection $price The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function filterByPrice($price, $comparison = null)
    {
        if ($price instanceof \GW2Exchange\Database\Price) {
            return $this
                ->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $price->getItemId(), $comparison);
        } elseif ($price instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PriceHistoryTableMap::COL_ITEM_ID, $price->toKeyValue('PrimaryKey', 'ItemId'), $comparison);
        } else {
            throw new PropelException('filterByPrice() only accepts arguments of type \GW2Exchange\Database\Price or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Price relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function joinPrice($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Price');

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
            $this->addJoinObject($join, 'Price');
        }

        return $this;
    }

    /**
     * Use the Price relation Price object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2Exchange\Database\PriceQuery A secondary query class using the current class as primary query
     */
    public function usePriceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPrice($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Price', '\GW2Exchange\Database\PriceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPriceHistory $priceHistory Object to remove from the list of results
     *
     * @return $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function prune($priceHistory = null)
    {
        if ($priceHistory) {
            $this->addUsingAlias(PriceHistoryTableMap::COL_ID, $priceHistory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the price_history table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PriceHistoryTableMap::clearInstancePool();
            PriceHistoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PriceHistoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PriceHistoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PriceHistoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PriceHistoryTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PriceHistoryTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPriceHistoryQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PriceHistoryTableMap::COL_CREATED_AT);
    }

} // PriceHistoryQuery
