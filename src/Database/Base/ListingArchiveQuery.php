<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\ListingArchive as ChildListingArchive;
use GW2Exchange\Database\ListingArchiveQuery as ChildListingArchiveQuery;
use GW2Exchange\Database\Map\ListingArchiveTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'listing_archive' table.
 *
 *
 *
 * @method     ChildListingArchiveQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildListingArchiveQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildListingArchiveQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildListingArchiveQuery orderByOrders($order = Criteria::ASC) Order by the orders column
 * @method     ChildListingArchiveQuery orderByUnitPrice($order = Criteria::ASC) Order by the unit_price column
 * @method     ChildListingArchiveQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildListingArchiveQuery orderByCacheTime($order = Criteria::ASC) Order by the cache_time column
 * @method     ChildListingArchiveQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildListingArchiveQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildListingArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method     ChildListingArchiveQuery groupById() Group by the id column
 * @method     ChildListingArchiveQuery groupByItemId() Group by the item_id column
 * @method     ChildListingArchiveQuery groupByType() Group by the type column
 * @method     ChildListingArchiveQuery groupByOrders() Group by the orders column
 * @method     ChildListingArchiveQuery groupByUnitPrice() Group by the unit_price column
 * @method     ChildListingArchiveQuery groupByQuantity() Group by the quantity column
 * @method     ChildListingArchiveQuery groupByCacheTime() Group by the cache_time column
 * @method     ChildListingArchiveQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildListingArchiveQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildListingArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method     ChildListingArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildListingArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildListingArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildListingArchive findOne(ConnectionInterface $con = null) Return the first ChildListingArchive matching the query
 * @method     ChildListingArchive findOneOrCreate(ConnectionInterface $con = null) Return the first ChildListingArchive matching the query, or a new ChildListingArchive object populated from the query conditions when no match is found
 *
 * @method     ChildListingArchive findOneById(int $id) Return the first ChildListingArchive filtered by the id column
 * @method     ChildListingArchive findOneByItemId(int $item_id) Return the first ChildListingArchive filtered by the item_id column
 * @method     ChildListingArchive findOneByType(string $type) Return the first ChildListingArchive filtered by the type column
 * @method     ChildListingArchive findOneByOrders(int $orders) Return the first ChildListingArchive filtered by the orders column
 * @method     ChildListingArchive findOneByUnitPrice(int $unit_price) Return the first ChildListingArchive filtered by the unit_price column
 * @method     ChildListingArchive findOneByQuantity(int $quantity) Return the first ChildListingArchive filtered by the quantity column
 * @method     ChildListingArchive findOneByCacheTime(int $cache_time) Return the first ChildListingArchive filtered by the cache_time column
 * @method     ChildListingArchive findOneByCreatedAt(string $created_at) Return the first ChildListingArchive filtered by the created_at column
 * @method     ChildListingArchive findOneByUpdatedAt(string $updated_at) Return the first ChildListingArchive filtered by the updated_at column
 * @method     ChildListingArchive findOneByArchivedAt(string $archived_at) Return the first ChildListingArchive filtered by the archived_at column *

 * @method     ChildListingArchive requirePk($key, ConnectionInterface $con = null) Return the ChildListingArchive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOne(ConnectionInterface $con = null) Return the first ChildListingArchive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildListingArchive requireOneById(int $id) Return the first ChildListingArchive filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByItemId(int $item_id) Return the first ChildListingArchive filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByType(string $type) Return the first ChildListingArchive filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByOrders(int $orders) Return the first ChildListingArchive filtered by the orders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByUnitPrice(int $unit_price) Return the first ChildListingArchive filtered by the unit_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByQuantity(int $quantity) Return the first ChildListingArchive filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByCacheTime(int $cache_time) Return the first ChildListingArchive filtered by the cache_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByCreatedAt(string $created_at) Return the first ChildListingArchive filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByUpdatedAt(string $updated_at) Return the first ChildListingArchive filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListingArchive requireOneByArchivedAt(string $archived_at) Return the first ChildListingArchive filtered by the archived_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildListingArchive[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildListingArchive objects based on current ModelCriteria
 * @method     ChildListingArchive[]|ObjectCollection findById(int $id) Return ChildListingArchive objects filtered by the id column
 * @method     ChildListingArchive[]|ObjectCollection findByItemId(int $item_id) Return ChildListingArchive objects filtered by the item_id column
 * @method     ChildListingArchive[]|ObjectCollection findByType(string $type) Return ChildListingArchive objects filtered by the type column
 * @method     ChildListingArchive[]|ObjectCollection findByOrders(int $orders) Return ChildListingArchive objects filtered by the orders column
 * @method     ChildListingArchive[]|ObjectCollection findByUnitPrice(int $unit_price) Return ChildListingArchive objects filtered by the unit_price column
 * @method     ChildListingArchive[]|ObjectCollection findByQuantity(int $quantity) Return ChildListingArchive objects filtered by the quantity column
 * @method     ChildListingArchive[]|ObjectCollection findByCacheTime(int $cache_time) Return ChildListingArchive objects filtered by the cache_time column
 * @method     ChildListingArchive[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildListingArchive objects filtered by the created_at column
 * @method     ChildListingArchive[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildListingArchive objects filtered by the updated_at column
 * @method     ChildListingArchive[]|ObjectCollection findByArchivedAt(string $archived_at) Return ChildListingArchive objects filtered by the archived_at column
 * @method     ChildListingArchive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ListingArchiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\ListingArchiveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'GW2Exchange', $modelName = '\\GW2Exchange\\Database\\ListingArchive', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildListingArchiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildListingArchiveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildListingArchiveQuery) {
            return $criteria;
        }
        $query = new ChildListingArchiveQuery();
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
     * @return ChildListingArchive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ListingArchiveTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ListingArchiveTableMap::DATABASE_NAME);
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
     * @return ChildListingArchive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, item_id, type, orders, unit_price, quantity, cache_time, created_at, updated_at, archived_at FROM listing_archive WHERE id = :p0';
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
            /** @var ChildListingArchive $obj */
            $obj = new ChildListingArchive();
            $obj->hydrate($row);
            ListingArchiveTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildListingArchive|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ListingArchiveTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ListingArchiveTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the orders column
     *
     * Example usage:
     * <code>
     * $query->filterByOrders(1234); // WHERE orders = 1234
     * $query->filterByOrders(array(12, 34)); // WHERE orders IN (12, 34)
     * $query->filterByOrders(array('min' => 12)); // WHERE orders > 12
     * </code>
     *
     * @param     mixed $orders The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByOrders($orders = null, $comparison = null)
    {
        if (is_array($orders)) {
            $useMinMax = false;
            if (isset($orders['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ORDERS, $orders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orders['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ORDERS, $orders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_ORDERS, $orders, $comparison);
    }

    /**
     * Filter the query on the unit_price column
     *
     * Example usage:
     * <code>
     * $query->filterByUnitPrice(1234); // WHERE unit_price = 1234
     * $query->filterByUnitPrice(array(12, 34)); // WHERE unit_price IN (12, 34)
     * $query->filterByUnitPrice(array('min' => 12)); // WHERE unit_price > 12
     * </code>
     *
     * @param     mixed $unitPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByUnitPrice($unitPrice = null, $comparison = null)
    {
        if (is_array($unitPrice)) {
            $useMinMax = false;
            if (isset($unitPrice['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_UNIT_PRICE, $unitPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitPrice['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_UNIT_PRICE, $unitPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_UNIT_PRICE, $unitPrice, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_QUANTITY, $quantity, $comparison);
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByCacheTime($cacheTime = null, $comparison = null)
    {
        if (is_array($cacheTime)) {
            $useMinMax = false;
            if (isset($cacheTime['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_CACHE_TIME, $cacheTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cacheTime['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_CACHE_TIME, $cacheTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_CACHE_TIME, $cacheTime, $comparison);
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(ListingArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingArchiveTableMap::COL_ARCHIVED_AT, $archivedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildListingArchive $listingArchive Object to remove from the list of results
     *
     * @return $this|ChildListingArchiveQuery The current query, for fluid interface
     */
    public function prune($listingArchive = null)
    {
        if ($listingArchive) {
            $this->addUsingAlias(ListingArchiveTableMap::COL_ID, $listingArchive->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the listing_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListingArchiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ListingArchiveTableMap::clearInstancePool();
            ListingArchiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ListingArchiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ListingArchiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ListingArchiveTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ListingArchiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ListingArchiveQuery
