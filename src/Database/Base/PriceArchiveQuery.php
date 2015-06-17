<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\PriceArchive as ChildPriceArchive;
use GW2Exchange\Database\PriceArchiveQuery as ChildPriceArchiveQuery;
use GW2Exchange\Database\Map\PriceArchiveTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'price_archive' table.
 *
 *
 *
 * @method     ChildPriceArchiveQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildPriceArchiveQuery orderByBuyPrice($order = Criteria::ASC) Order by the buy_price column
 * @method     ChildPriceArchiveQuery orderBySellPrice($order = Criteria::ASC) Order by the sell_price column
 * @method     ChildPriceArchiveQuery orderByBuyQty($order = Criteria::ASC) Order by the buy_qty column
 * @method     ChildPriceArchiveQuery orderBySellQty($order = Criteria::ASC) Order by the sell_qty column
 * @method     ChildPriceArchiveQuery orderByCacheTime($order = Criteria::ASC) Order by the cache_time column
 * @method     ChildPriceArchiveQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPriceArchiveQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildPriceArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method     ChildPriceArchiveQuery groupByItemId() Group by the item_id column
 * @method     ChildPriceArchiveQuery groupByBuyPrice() Group by the buy_price column
 * @method     ChildPriceArchiveQuery groupBySellPrice() Group by the sell_price column
 * @method     ChildPriceArchiveQuery groupByBuyQty() Group by the buy_qty column
 * @method     ChildPriceArchiveQuery groupBySellQty() Group by the sell_qty column
 * @method     ChildPriceArchiveQuery groupByCacheTime() Group by the cache_time column
 * @method     ChildPriceArchiveQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPriceArchiveQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildPriceArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method     ChildPriceArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPriceArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPriceArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPriceArchive findOne(ConnectionInterface $con = null) Return the first ChildPriceArchive matching the query
 * @method     ChildPriceArchive findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPriceArchive matching the query, or a new ChildPriceArchive object populated from the query conditions when no match is found
 *
 * @method     ChildPriceArchive findOneByItemId(int $item_id) Return the first ChildPriceArchive filtered by the item_id column
 * @method     ChildPriceArchive findOneByBuyPrice(int $buy_price) Return the first ChildPriceArchive filtered by the buy_price column
 * @method     ChildPriceArchive findOneBySellPrice(int $sell_price) Return the first ChildPriceArchive filtered by the sell_price column
 * @method     ChildPriceArchive findOneByBuyQty(int $buy_qty) Return the first ChildPriceArchive filtered by the buy_qty column
 * @method     ChildPriceArchive findOneBySellQty(int $sell_qty) Return the first ChildPriceArchive filtered by the sell_qty column
 * @method     ChildPriceArchive findOneByCacheTime(int $cache_time) Return the first ChildPriceArchive filtered by the cache_time column
 * @method     ChildPriceArchive findOneByCreatedAt(string $created_at) Return the first ChildPriceArchive filtered by the created_at column
 * @method     ChildPriceArchive findOneByUpdatedAt(string $updated_at) Return the first ChildPriceArchive filtered by the updated_at column
 * @method     ChildPriceArchive findOneByArchivedAt(string $archived_at) Return the first ChildPriceArchive filtered by the archived_at column *

 * @method     ChildPriceArchive requirePk($key, ConnectionInterface $con = null) Return the ChildPriceArchive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOne(ConnectionInterface $con = null) Return the first ChildPriceArchive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPriceArchive requireOneByItemId(int $item_id) Return the first ChildPriceArchive filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneByBuyPrice(int $buy_price) Return the first ChildPriceArchive filtered by the buy_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneBySellPrice(int $sell_price) Return the first ChildPriceArchive filtered by the sell_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneByBuyQty(int $buy_qty) Return the first ChildPriceArchive filtered by the buy_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneBySellQty(int $sell_qty) Return the first ChildPriceArchive filtered by the sell_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneByCacheTime(int $cache_time) Return the first ChildPriceArchive filtered by the cache_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneByCreatedAt(string $created_at) Return the first ChildPriceArchive filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneByUpdatedAt(string $updated_at) Return the first ChildPriceArchive filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceArchive requireOneByArchivedAt(string $archived_at) Return the first ChildPriceArchive filtered by the archived_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPriceArchive[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPriceArchive objects based on current ModelCriteria
 * @method     ChildPriceArchive[]|ObjectCollection findByItemId(int $item_id) Return ChildPriceArchive objects filtered by the item_id column
 * @method     ChildPriceArchive[]|ObjectCollection findByBuyPrice(int $buy_price) Return ChildPriceArchive objects filtered by the buy_price column
 * @method     ChildPriceArchive[]|ObjectCollection findBySellPrice(int $sell_price) Return ChildPriceArchive objects filtered by the sell_price column
 * @method     ChildPriceArchive[]|ObjectCollection findByBuyQty(int $buy_qty) Return ChildPriceArchive objects filtered by the buy_qty column
 * @method     ChildPriceArchive[]|ObjectCollection findBySellQty(int $sell_qty) Return ChildPriceArchive objects filtered by the sell_qty column
 * @method     ChildPriceArchive[]|ObjectCollection findByCacheTime(int $cache_time) Return ChildPriceArchive objects filtered by the cache_time column
 * @method     ChildPriceArchive[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPriceArchive objects filtered by the created_at column
 * @method     ChildPriceArchive[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPriceArchive objects filtered by the updated_at column
 * @method     ChildPriceArchive[]|ObjectCollection findByArchivedAt(string $archived_at) Return ChildPriceArchive objects filtered by the archived_at column
 * @method     ChildPriceArchive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PriceArchiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\PriceArchiveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'GW2Exchange', $modelName = '\\GW2Exchange\\Database\\PriceArchive', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPriceArchiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPriceArchiveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPriceArchiveQuery) {
            return $criteria;
        }
        $query = new ChildPriceArchiveQuery();
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
     * @return ChildPriceArchive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PriceArchiveTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PriceArchiveTableMap::DATABASE_NAME);
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
     * @return ChildPriceArchive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, buy_price, sell_price, buy_qty, sell_qty, cache_time, created_at, updated_at, archived_at FROM price_archive WHERE item_id = :p0';
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
            /** @var ChildPriceArchive $obj */
            $obj = new ChildPriceArchive();
            $obj->hydrate($row);
            PriceArchiveTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPriceArchive|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PriceArchiveTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PriceArchiveTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_ITEM_ID, $itemId, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByBuyPrice($buyPrice = null, $comparison = null)
    {
        if (is_array($buyPrice)) {
            $useMinMax = false;
            if (isset($buyPrice['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_BUY_PRICE, $buyPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyPrice['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_BUY_PRICE, $buyPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_BUY_PRICE, $buyPrice, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterBySellPrice($sellPrice = null, $comparison = null)
    {
        if (is_array($sellPrice)) {
            $useMinMax = false;
            if (isset($sellPrice['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_SELL_PRICE, $sellPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellPrice['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_SELL_PRICE, $sellPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_SELL_PRICE, $sellPrice, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByBuyQty($buyQty = null, $comparison = null)
    {
        if (is_array($buyQty)) {
            $useMinMax = false;
            if (isset($buyQty['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_BUY_QTY, $buyQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyQty['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_BUY_QTY, $buyQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_BUY_QTY, $buyQty, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterBySellQty($sellQty = null, $comparison = null)
    {
        if (is_array($sellQty)) {
            $useMinMax = false;
            if (isset($sellQty['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_SELL_QTY, $sellQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellQty['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_SELL_QTY, $sellQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_SELL_QTY, $sellQty, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByCacheTime($cacheTime = null, $comparison = null)
    {
        if (is_array($cacheTime)) {
            $useMinMax = false;
            if (isset($cacheTime['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_CACHE_TIME, $cacheTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cacheTime['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_CACHE_TIME, $cacheTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_CACHE_TIME, $cacheTime, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the archived_at column
     *
     * Example usage:
     * <code>
     * $query->filterByArchivedAt('2011-03-14'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt('now'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt(array('max' => 'yesterday')); // WHERE archived_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $archivedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(PriceArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceArchiveTableMap::COL_ARCHIVED_AT, $archivedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPriceArchive $priceArchive Object to remove from the list of results
     *
     * @return $this|ChildPriceArchiveQuery The current query, for fluid interface
     */
    public function prune($priceArchive = null)
    {
        if ($priceArchive) {
            $this->addUsingAlias(PriceArchiveTableMap::COL_ITEM_ID, $priceArchive->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the price_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceArchiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PriceArchiveTableMap::clearInstancePool();
            PriceArchiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceArchiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PriceArchiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PriceArchiveTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PriceArchiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PriceArchiveQuery
