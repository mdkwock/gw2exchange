<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\Price as ChildPrice;
use GW2Exchange\Database\PriceQuery as ChildPriceQuery;
use GW2Exchange\Database\Map\PriceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'price' table.
 *
 *
 *
 * @method     ChildPriceQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildPriceQuery orderByBuyPrice($order = Criteria::ASC) Order by the buy_price column
 * @method     ChildPriceQuery orderBySellPrice($order = Criteria::ASC) Order by the sell_price column
 * @method     ChildPriceQuery orderByBuyQty($order = Criteria::ASC) Order by the buy_qty column
 * @method     ChildPriceQuery orderBySellQty($order = Criteria::ASC) Order by the sell_qty column
 * @method     ChildPriceQuery orderByHash($order = Criteria::ASC) Order by the hash column
 * @method     ChildPriceQuery orderByProfit($order = Criteria::ASC) Order by the profit column
 * @method     ChildPriceQuery orderByRoi($order = Criteria::ASC) Order by the roi column
 * @method     ChildPriceQuery orderByCacheTime($order = Criteria::ASC) Order by the cache_time column
 * @method     ChildPriceQuery orderByMaxBuy($order = Criteria::ASC) Order by the max_buy column
 * @method     ChildPriceQuery orderByMinBuy($order = Criteria::ASC) Order by the min_buy column
 * @method     ChildPriceQuery orderByMaxSell($order = Criteria::ASC) Order by the max_sell column
 * @method     ChildPriceQuery orderByMinSell($order = Criteria::ASC) Order by the min_sell column
 * @method     ChildPriceQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPriceQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPriceQuery groupByItemId() Group by the item_id column
 * @method     ChildPriceQuery groupByBuyPrice() Group by the buy_price column
 * @method     ChildPriceQuery groupBySellPrice() Group by the sell_price column
 * @method     ChildPriceQuery groupByBuyQty() Group by the buy_qty column
 * @method     ChildPriceQuery groupBySellQty() Group by the sell_qty column
 * @method     ChildPriceQuery groupByHash() Group by the hash column
 * @method     ChildPriceQuery groupByProfit() Group by the profit column
 * @method     ChildPriceQuery groupByRoi() Group by the roi column
 * @method     ChildPriceQuery groupByCacheTime() Group by the cache_time column
 * @method     ChildPriceQuery groupByMaxBuy() Group by the max_buy column
 * @method     ChildPriceQuery groupByMinBuy() Group by the min_buy column
 * @method     ChildPriceQuery groupByMaxSell() Group by the max_sell column
 * @method     ChildPriceQuery groupByMinSell() Group by the min_sell column
 * @method     ChildPriceQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPriceQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPriceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPriceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPriceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPriceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPriceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPriceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPriceQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildPriceQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildPriceQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildPriceQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildPriceQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildPriceQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildPriceQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     ChildPriceQuery leftJoinPriceHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the PriceHistory relation
 * @method     ChildPriceQuery rightJoinPriceHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PriceHistory relation
 * @method     ChildPriceQuery innerJoinPriceHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the PriceHistory relation
 *
 * @method     ChildPriceQuery joinWithPriceHistory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PriceHistory relation
 *
 * @method     ChildPriceQuery leftJoinWithPriceHistory() Adds a LEFT JOIN clause and with to the query using the PriceHistory relation
 * @method     ChildPriceQuery rightJoinWithPriceHistory() Adds a RIGHT JOIN clause and with to the query using the PriceHistory relation
 * @method     ChildPriceQuery innerJoinWithPriceHistory() Adds a INNER JOIN clause and with to the query using the PriceHistory relation
 *
 * @method     \GW2Exchange\Database\ItemQuery|\GW2Exchange\Database\PriceHistoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPrice findOne(ConnectionInterface $con = null) Return the first ChildPrice matching the query
 * @method     ChildPrice findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPrice matching the query, or a new ChildPrice object populated from the query conditions when no match is found
 *
 * @method     ChildPrice findOneByItemId(int $item_id) Return the first ChildPrice filtered by the item_id column
 * @method     ChildPrice findOneByBuyPrice(int $buy_price) Return the first ChildPrice filtered by the buy_price column
 * @method     ChildPrice findOneBySellPrice(int $sell_price) Return the first ChildPrice filtered by the sell_price column
 * @method     ChildPrice findOneByBuyQty(int $buy_qty) Return the first ChildPrice filtered by the buy_qty column
 * @method     ChildPrice findOneBySellQty(int $sell_qty) Return the first ChildPrice filtered by the sell_qty column
 * @method     ChildPrice findOneByHash(string $hash) Return the first ChildPrice filtered by the hash column
 * @method     ChildPrice findOneByProfit(int $profit) Return the first ChildPrice filtered by the profit column
 * @method     ChildPrice findOneByRoi(double $roi) Return the first ChildPrice filtered by the roi column
 * @method     ChildPrice findOneByCacheTime(int $cache_time) Return the first ChildPrice filtered by the cache_time column
 * @method     ChildPrice findOneByMaxBuy(int $max_buy) Return the first ChildPrice filtered by the max_buy column
 * @method     ChildPrice findOneByMinBuy(int $min_buy) Return the first ChildPrice filtered by the min_buy column
 * @method     ChildPrice findOneByMaxSell(int $max_sell) Return the first ChildPrice filtered by the max_sell column
 * @method     ChildPrice findOneByMinSell(int $min_sell) Return the first ChildPrice filtered by the min_sell column
 * @method     ChildPrice findOneByCreatedAt(string $created_at) Return the first ChildPrice filtered by the created_at column
 * @method     ChildPrice findOneByUpdatedAt(string $updated_at) Return the first ChildPrice filtered by the updated_at column *

 * @method     ChildPrice requirePk($key, ConnectionInterface $con = null) Return the ChildPrice by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOne(ConnectionInterface $con = null) Return the first ChildPrice matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrice requireOneByItemId(int $item_id) Return the first ChildPrice filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByBuyPrice(int $buy_price) Return the first ChildPrice filtered by the buy_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneBySellPrice(int $sell_price) Return the first ChildPrice filtered by the sell_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByBuyQty(int $buy_qty) Return the first ChildPrice filtered by the buy_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneBySellQty(int $sell_qty) Return the first ChildPrice filtered by the sell_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByHash(string $hash) Return the first ChildPrice filtered by the hash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByProfit(int $profit) Return the first ChildPrice filtered by the profit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByRoi(double $roi) Return the first ChildPrice filtered by the roi column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByCacheTime(int $cache_time) Return the first ChildPrice filtered by the cache_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByMaxBuy(int $max_buy) Return the first ChildPrice filtered by the max_buy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByMinBuy(int $min_buy) Return the first ChildPrice filtered by the min_buy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByMaxSell(int $max_sell) Return the first ChildPrice filtered by the max_sell column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByMinSell(int $min_sell) Return the first ChildPrice filtered by the min_sell column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByCreatedAt(string $created_at) Return the first ChildPrice filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrice requireOneByUpdatedAt(string $updated_at) Return the first ChildPrice filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrice[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPrice objects based on current ModelCriteria
 * @method     ChildPrice[]|ObjectCollection findByItemId(int $item_id) Return ChildPrice objects filtered by the item_id column
 * @method     ChildPrice[]|ObjectCollection findByBuyPrice(int $buy_price) Return ChildPrice objects filtered by the buy_price column
 * @method     ChildPrice[]|ObjectCollection findBySellPrice(int $sell_price) Return ChildPrice objects filtered by the sell_price column
 * @method     ChildPrice[]|ObjectCollection findByBuyQty(int $buy_qty) Return ChildPrice objects filtered by the buy_qty column
 * @method     ChildPrice[]|ObjectCollection findBySellQty(int $sell_qty) Return ChildPrice objects filtered by the sell_qty column
 * @method     ChildPrice[]|ObjectCollection findByHash(string $hash) Return ChildPrice objects filtered by the hash column
 * @method     ChildPrice[]|ObjectCollection findByProfit(int $profit) Return ChildPrice objects filtered by the profit column
 * @method     ChildPrice[]|ObjectCollection findByRoi(double $roi) Return ChildPrice objects filtered by the roi column
 * @method     ChildPrice[]|ObjectCollection findByCacheTime(int $cache_time) Return ChildPrice objects filtered by the cache_time column
 * @method     ChildPrice[]|ObjectCollection findByMaxBuy(int $max_buy) Return ChildPrice objects filtered by the max_buy column
 * @method     ChildPrice[]|ObjectCollection findByMinBuy(int $min_buy) Return ChildPrice objects filtered by the min_buy column
 * @method     ChildPrice[]|ObjectCollection findByMaxSell(int $max_sell) Return ChildPrice objects filtered by the max_sell column
 * @method     ChildPrice[]|ObjectCollection findByMinSell(int $min_sell) Return ChildPrice objects filtered by the min_sell column
 * @method     ChildPrice[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPrice objects filtered by the created_at column
 * @method     ChildPrice[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPrice objects filtered by the updated_at column
 * @method     ChildPrice[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PriceQuery extends ModelCriteria
{

    // query_cache behavior
    protected $queryKey = '';
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\PriceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2exchange', $modelName = '\\GW2Exchange\\Database\\Price', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPriceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPriceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPriceQuery) {
            return $criteria;
        }
        $query = new ChildPriceQuery();
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
     * @return ChildPrice|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PriceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PriceTableMap::DATABASE_NAME);
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
     * @return ChildPrice A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, buy_price, sell_price, buy_qty, sell_qty, hash, profit, roi, cache_time, max_buy, min_buy, max_sell, min_sell, created_at, updated_at FROM price WHERE item_id = :p0';
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
            /** @var ChildPrice $obj */
            $obj = new ChildPrice();
            $obj->hydrate($row);
            PriceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPrice|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PriceTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PriceTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_ITEM_ID, $itemId, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByBuyPrice($buyPrice = null, $comparison = null)
    {
        if (is_array($buyPrice)) {
            $useMinMax = false;
            if (isset($buyPrice['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_BUY_PRICE, $buyPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyPrice['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_BUY_PRICE, $buyPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_BUY_PRICE, $buyPrice, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterBySellPrice($sellPrice = null, $comparison = null)
    {
        if (is_array($sellPrice)) {
            $useMinMax = false;
            if (isset($sellPrice['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_SELL_PRICE, $sellPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellPrice['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_SELL_PRICE, $sellPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_SELL_PRICE, $sellPrice, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByBuyQty($buyQty = null, $comparison = null)
    {
        if (is_array($buyQty)) {
            $useMinMax = false;
            if (isset($buyQty['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_BUY_QTY, $buyQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyQty['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_BUY_QTY, $buyQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_BUY_QTY, $buyQty, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterBySellQty($sellQty = null, $comparison = null)
    {
        if (is_array($sellQty)) {
            $useMinMax = false;
            if (isset($sellQty['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_SELL_QTY, $sellQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellQty['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_SELL_QTY, $sellQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_SELL_QTY, $sellQty, $comparison);
    }

    /**
     * Filter the query on the hash column
     *
     * Example usage:
     * <code>
     * $query->filterByHash('fooValue');   // WHERE hash = 'fooValue'
     * $query->filterByHash('%fooValue%'); // WHERE hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByHash($hash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hash)) {
                $hash = str_replace('*', '%', $hash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_HASH, $hash, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByProfit($profit = null, $comparison = null)
    {
        if (is_array($profit)) {
            $useMinMax = false;
            if (isset($profit['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_PROFIT, $profit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profit['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_PROFIT, $profit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_PROFIT, $profit, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByRoi($roi = null, $comparison = null)
    {
        if (is_array($roi)) {
            $useMinMax = false;
            if (isset($roi['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_ROI, $roi['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roi['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_ROI, $roi['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_ROI, $roi, $comparison);
    }

    /**
     * Filter the query on the cache_time column
     *
     * Example usage:
     * <code>
     * $query->filterByCacheTime(1234); // WHERE cache_time = 1234
     * $query->filterByCacheTime(array(12, 34)); // WHERE cache_time IN (12, 34)
     * $query->filterByCacheTime(array('min' => 12)); // WHERE cache_time > 12
     * </code>
     *
     * @param     mixed $cacheTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByCacheTime($cacheTime = null, $comparison = null)
    {
        if (is_array($cacheTime)) {
            $useMinMax = false;
            if (isset($cacheTime['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_CACHE_TIME, $cacheTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cacheTime['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_CACHE_TIME, $cacheTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_CACHE_TIME, $cacheTime, $comparison);
    }

    /**
     * Filter the query on the max_buy column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxBuy(1234); // WHERE max_buy = 1234
     * $query->filterByMaxBuy(array(12, 34)); // WHERE max_buy IN (12, 34)
     * $query->filterByMaxBuy(array('min' => 12)); // WHERE max_buy > 12
     * </code>
     *
     * @param     mixed $maxBuy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByMaxBuy($maxBuy = null, $comparison = null)
    {
        if (is_array($maxBuy)) {
            $useMinMax = false;
            if (isset($maxBuy['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_MAX_BUY, $maxBuy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxBuy['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_MAX_BUY, $maxBuy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_MAX_BUY, $maxBuy, $comparison);
    }

    /**
     * Filter the query on the min_buy column
     *
     * Example usage:
     * <code>
     * $query->filterByMinBuy(1234); // WHERE min_buy = 1234
     * $query->filterByMinBuy(array(12, 34)); // WHERE min_buy IN (12, 34)
     * $query->filterByMinBuy(array('min' => 12)); // WHERE min_buy > 12
     * </code>
     *
     * @param     mixed $minBuy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByMinBuy($minBuy = null, $comparison = null)
    {
        if (is_array($minBuy)) {
            $useMinMax = false;
            if (isset($minBuy['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_MIN_BUY, $minBuy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minBuy['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_MIN_BUY, $minBuy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_MIN_BUY, $minBuy, $comparison);
    }

    /**
     * Filter the query on the max_sell column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxSell(1234); // WHERE max_sell = 1234
     * $query->filterByMaxSell(array(12, 34)); // WHERE max_sell IN (12, 34)
     * $query->filterByMaxSell(array('min' => 12)); // WHERE max_sell > 12
     * </code>
     *
     * @param     mixed $maxSell The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByMaxSell($maxSell = null, $comparison = null)
    {
        if (is_array($maxSell)) {
            $useMinMax = false;
            if (isset($maxSell['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_MAX_SELL, $maxSell['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxSell['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_MAX_SELL, $maxSell['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_MAX_SELL, $maxSell, $comparison);
    }

    /**
     * Filter the query on the min_sell column
     *
     * Example usage:
     * <code>
     * $query->filterByMinSell(1234); // WHERE min_sell = 1234
     * $query->filterByMinSell(array(12, 34)); // WHERE min_sell IN (12, 34)
     * $query->filterByMinSell(array('min' => 12)); // WHERE min_sell > 12
     * </code>
     *
     * @param     mixed $minSell The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByMinSell($minSell = null, $comparison = null)
    {
        if (is_array($minSell)) {
            $useMinMax = false;
            if (isset($minSell['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_MIN_SELL, $minSell['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minSell['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_MIN_SELL, $minSell['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_MIN_SELL, $minSell, $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PriceTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PriceTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\Item object
     *
     * @param \GW2Exchange\Database\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPriceQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \GW2Exchange\Database\Item) {
            return $this
                ->addUsingAlias(PriceTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PriceTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPriceQuery The current query, for fluid interface
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
     * @return \GW2Exchange\Database\ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\GW2Exchange\Database\ItemQuery');
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\PriceHistory object
     *
     * @param \GW2Exchange\Database\PriceHistory|ObjectCollection $priceHistory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceQuery The current query, for fluid interface
     */
    public function filterByPriceHistory($priceHistory, $comparison = null)
    {
        if ($priceHistory instanceof \GW2Exchange\Database\PriceHistory) {
            return $this
                ->addUsingAlias(PriceTableMap::COL_ITEM_ID, $priceHistory->getItemId(), $comparison);
        } elseif ($priceHistory instanceof ObjectCollection) {
            return $this
                ->usePriceHistoryQuery()
                ->filterByPrimaryKeys($priceHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPriceHistory() only accepts arguments of type \GW2Exchange\Database\PriceHistory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PriceHistory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function joinPriceHistory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PriceHistory');

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
            $this->addJoinObject($join, 'PriceHistory');
        }

        return $this;
    }

    /**
     * Use the PriceHistory relation PriceHistory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2Exchange\Database\PriceHistoryQuery A secondary query class using the current class as primary query
     */
    public function usePriceHistoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPriceHistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PriceHistory', '\GW2Exchange\Database\PriceHistoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPrice $price Object to remove from the list of results
     *
     * @return $this|ChildPriceQuery The current query, for fluid interface
     */
    public function prune($price = null)
    {
        if ($price) {
            $this->addUsingAlias(PriceTableMap::COL_ITEM_ID, $price->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the price table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PriceTableMap::clearInstancePool();
            PriceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PriceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PriceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PriceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildPriceQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PriceTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildPriceQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PriceTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildPriceQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PriceTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPriceQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PriceTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPriceQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PriceTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPriceQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PriceTableMap::COL_CREATED_AT);
    }

    // query_cache behavior

    public function setQueryKey($key)
    {
        $this->queryKey = $key;

        return $this;
    }

    public function getQueryKey()
    {
        return $this->queryKey;
    }

    public function cacheContains($key)
    {

        return apc_fetch($key);
    }

    public function cacheFetch($key)
    {

        return apc_fetch($key);
    }

    public function cacheStore($key, $value, $lifetime = 3600)
    {
        apc_store($key, $value, $lifetime);
    }

    public function doSelect(ConnectionInterface $con = null)
    {
        // check that the columns of the main class are already added (if this is the primary ModelCriteria)
        if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
            $this->addSelfSelectColumns();
        }
        $this->configureSelectColumns();

        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PriceTableMap::DATABASE_NAME);
        $db = Propel::getServiceContainer()->getAdapter(PriceTableMap::DATABASE_NAME);

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            $params = array();
            $sql = $this->createSelectSql($params);
            if ($key) {
                $this->cacheStore($key, $sql);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
            } catch (Exception $e) {
                Propel::log($e->getMessage(), Propel::LOG_ERR);
                throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
            }

        return $con->getDataFetcher($stmt);
    }

    public function doCount(ConnectionInterface $con = null)
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap($this->getDbName());
        $db = Propel::getServiceContainer()->getAdapter($this->getDbName());

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            // check that the columns of the main class are already added (if this is the primary ModelCriteria)
            if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
                $this->addSelfSelectColumns();
            }

            $this->configureSelectColumns();

            $needsComplexCount = $this->getGroupByColumns()
                || $this->getOffset()
                || $this->getLimit() >= 0
                || $this->getHaving()
                || in_array(Criteria::DISTINCT, $this->getSelectModifiers())
                || count($this->selectQueries) > 0
            ;

            $params = array();
            if ($needsComplexCount) {
                if ($this->needsSelectAliases()) {
                    if ($this->getHaving()) {
                        throw new PropelException('Propel cannot create a COUNT query when using HAVING and  duplicate column names in the SELECT part');
                    }
                    $db->turnSelectColumnsToAliases($this);
                }
                $selectSql = $this->createSelectSql($params);
                $sql = 'SELECT COUNT(*) FROM (' . $selectSql . ') propelmatch4cnt';
            } else {
                // Replace SELECT columns with COUNT(*)
                $this->clearSelectColumns()->addSelectColumn('COUNT(*)');
                $sql = $this->createSelectSql($params);
            }

            if ($key) {
                $this->cacheStore($key, $sql);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute COUNT statement [%s]', $sql), 0, $e);
        }

        return $con->getDataFetcher($stmt);
    }

} // PriceQuery
