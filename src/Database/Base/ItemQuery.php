<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\Item as ChildItem;
use GW2Exchange\Database\ItemQuery as ChildItemQuery;
use GW2Exchange\Database\Map\ItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item' table.
 *
 *
 *
 * @method     ChildItemQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildItemQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildItemQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method     ChildItemQuery orderByHash($order = Criteria::ASC) Order by the hash column
 * @method     ChildItemQuery orderByCacheTime($order = Criteria::ASC) Order by the cache_time column
 * @method     ChildItemQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildItemQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildItemQuery groupById() Group by the id column
 * @method     ChildItemQuery groupByName() Group by the name column
 * @method     ChildItemQuery groupByIcon() Group by the icon column
 * @method     ChildItemQuery groupByHash() Group by the hash column
 * @method     ChildItemQuery groupByCacheTime() Group by the cache_time column
 * @method     ChildItemQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildItemQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemQuery leftJoinItemInfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemInfo relation
 * @method     ChildItemQuery rightJoinItemInfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemInfo relation
 * @method     ChildItemQuery innerJoinItemInfo($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemInfo relation
 *
 * @method     ChildItemQuery leftJoinItemItemDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemItemDetail relation
 * @method     ChildItemQuery rightJoinItemItemDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemItemDetail relation
 * @method     ChildItemQuery innerJoinItemItemDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemItemDetail relation
 *
 * @method     ChildItemQuery leftJoinListing($relationAlias = null) Adds a LEFT JOIN clause to the query using the Listing relation
 * @method     ChildItemQuery rightJoinListing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Listing relation
 * @method     ChildItemQuery innerJoinListing($relationAlias = null) Adds a INNER JOIN clause to the query using the Listing relation
 *
 * @method     ChildItemQuery leftJoinPrice($relationAlias = null) Adds a LEFT JOIN clause to the query using the Price relation
 * @method     ChildItemQuery rightJoinPrice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Price relation
 * @method     ChildItemQuery innerJoinPrice($relationAlias = null) Adds a INNER JOIN clause to the query using the Price relation
 *
 * @method     ChildItemQuery leftJoinPriceHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the PriceHistory relation
 * @method     ChildItemQuery rightJoinPriceHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PriceHistory relation
 * @method     ChildItemQuery innerJoinPriceHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the PriceHistory relation
 *
 * @method     \GW2Exchange\Database\ItemInfoQuery|\GW2Exchange\Database\ItemItemDetailQuery|\GW2Exchange\Database\ListingQuery|\GW2Exchange\Database\PriceQuery|\GW2Exchange\Database\PriceHistoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItem findOne(ConnectionInterface $con = null) Return the first ChildItem matching the query
 * @method     ChildItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItem matching the query, or a new ChildItem object populated from the query conditions when no match is found
 *
 * @method     ChildItem findOneById(int $id) Return the first ChildItem filtered by the id column
 * @method     ChildItem findOneByName(string $name) Return the first ChildItem filtered by the name column
 * @method     ChildItem findOneByIcon(string $icon) Return the first ChildItem filtered by the icon column
 * @method     ChildItem findOneByHash(string $hash) Return the first ChildItem filtered by the hash column
 * @method     ChildItem findOneByCacheTime(int $cache_time) Return the first ChildItem filtered by the cache_time column
 * @method     ChildItem findOneByCreatedAt(string $created_at) Return the first ChildItem filtered by the created_at column
 * @method     ChildItem findOneByUpdatedAt(string $updated_at) Return the first ChildItem filtered by the updated_at column *

 * @method     ChildItem requirePk($key, ConnectionInterface $con = null) Return the ChildItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOne(ConnectionInterface $con = null) Return the first ChildItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem requireOneById(int $id) Return the first ChildItem filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByName(string $name) Return the first ChildItem filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByIcon(string $icon) Return the first ChildItem filtered by the icon column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByHash(string $hash) Return the first ChildItem filtered by the hash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByCacheTime(int $cache_time) Return the first ChildItem filtered by the cache_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByCreatedAt(string $created_at) Return the first ChildItem filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByUpdatedAt(string $updated_at) Return the first ChildItem filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItem objects based on current ModelCriteria
 * @method     ChildItem[]|ObjectCollection findById(int $id) Return ChildItem objects filtered by the id column
 * @method     ChildItem[]|ObjectCollection findByName(string $name) Return ChildItem objects filtered by the name column
 * @method     ChildItem[]|ObjectCollection findByIcon(string $icon) Return ChildItem objects filtered by the icon column
 * @method     ChildItem[]|ObjectCollection findByHash(string $hash) Return ChildItem objects filtered by the hash column
 * @method     ChildItem[]|ObjectCollection findByCacheTime(int $cache_time) Return ChildItem objects filtered by the cache_time column
 * @method     ChildItem[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildItem objects filtered by the created_at column
 * @method     ChildItem[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildItem objects filtered by the updated_at column
 * @method     ChildItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemQuery extends ModelCriteria
{

    // query_cache behavior
    protected $queryKey = '';
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\ItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2exchange', $modelName = '\\GW2Exchange\\Database\\Item', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemQuery) {
            return $criteria;
        }
        $query = new ChildItemQuery();
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
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
     * @return ChildItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, icon, hash, cache_time, created_at, updated_at FROM item WHERE id = :p0';
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
            /** @var ChildItem $obj */
            $obj = new ChildItem();
            $obj->hydrate($row);
            ItemTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the icon column
     *
     * Example usage:
     * <code>
     * $query->filterByIcon('fooValue');   // WHERE icon = 'fooValue'
     * $query->filterByIcon('%fooValue%'); // WHERE icon LIKE '%fooValue%'
     * </code>
     *
     * @param     string $icon The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByIcon($icon = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($icon)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $icon)) {
                $icon = str_replace('*', '%', $icon);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ICON, $icon, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ItemTableMap::COL_HASH, $hash, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByCacheTime($cacheTime = null, $comparison = null)
    {
        if (is_array($cacheTime)) {
            $useMinMax = false;
            if (isset($cacheTime['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_CACHE_TIME, $cacheTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cacheTime['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_CACHE_TIME, $cacheTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_CACHE_TIME, $cacheTime, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\ItemInfo object
     *
     * @param \GW2Exchange\Database\ItemInfo|ObjectCollection $itemInfo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemInfo($itemInfo, $comparison = null)
    {
        if ($itemInfo instanceof \GW2Exchange\Database\ItemInfo) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ID, $itemInfo->getItemId(), $comparison);
        } elseif ($itemInfo instanceof ObjectCollection) {
            return $this
                ->useItemInfoQuery()
                ->filterByPrimaryKeys($itemInfo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemInfo() only accepts arguments of type \GW2Exchange\Database\ItemInfo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemInfo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinItemInfo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemInfo');

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
            $this->addJoinObject($join, 'ItemInfo');
        }

        return $this;
    }

    /**
     * Use the ItemInfo relation ItemInfo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2Exchange\Database\ItemInfoQuery A secondary query class using the current class as primary query
     */
    public function useItemInfoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemInfo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemInfo', '\GW2Exchange\Database\ItemInfoQuery');
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\ItemItemDetail object
     *
     * @param \GW2Exchange\Database\ItemItemDetail|ObjectCollection $itemItemDetail the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemItemDetail($itemItemDetail, $comparison = null)
    {
        if ($itemItemDetail instanceof \GW2Exchange\Database\ItemItemDetail) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ID, $itemItemDetail->getItemId(), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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
     * Filter the query by a related \GW2Exchange\Database\Listing object
     *
     * @param \GW2Exchange\Database\Listing|ObjectCollection $listing the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByListing($listing, $comparison = null)
    {
        if ($listing instanceof \GW2Exchange\Database\Listing) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ID, $listing->getItemId(), $comparison);
        } elseif ($listing instanceof ObjectCollection) {
            return $this
                ->useListingQuery()
                ->filterByPrimaryKeys($listing->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByListing() only accepts arguments of type \GW2Exchange\Database\Listing or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Listing relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinListing($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Listing');

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
            $this->addJoinObject($join, 'Listing');
        }

        return $this;
    }

    /**
     * Use the Listing relation Listing object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GW2Exchange\Database\ListingQuery A secondary query class using the current class as primary query
     */
    public function useListingQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinListing($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Listing', '\GW2Exchange\Database\ListingQuery');
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\Price object
     *
     * @param \GW2Exchange\Database\Price|ObjectCollection $price the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrice($price, $comparison = null)
    {
        if ($price instanceof \GW2Exchange\Database\Price) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ID, $price->getItemId(), $comparison);
        } elseif ($price instanceof ObjectCollection) {
            return $this
                ->usePriceQuery()
                ->filterByPrimaryKeys($price->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinPrice($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function usePriceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPrice($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Price', '\GW2Exchange\Database\PriceQuery');
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\PriceHistory object
     *
     * @param \GW2Exchange\Database\PriceHistory|ObjectCollection $priceHistory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByPriceHistory($priceHistory, $comparison = null)
    {
        if ($priceHistory instanceof \GW2Exchange\Database\PriceHistory) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ID, $priceHistory->getItemId(), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinPriceHistory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function usePriceHistoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPriceHistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PriceHistory', '\GW2Exchange\Database\PriceHistoryQuery');
    }

    /**
     * Filter the query by a related ItemDetail object
     * using the item_item_detail table as cross reference
     *
     * @param ItemDetail $itemDetail the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemDetail($itemDetail, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useItemItemDetailQuery()
            ->filterByItemDetail($itemDetail, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItem $item Object to remove from the list of results
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function prune($item = null)
    {
        if ($item) {
            $this->addUsingAlias(ItemTableMap::COL_ID, $item->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemTableMap::clearInstancePool();
            ItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildItemQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ItemTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildItemQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ItemTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildItemQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ItemTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildItemQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ItemTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildItemQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ItemTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildItemQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ItemTableMap::COL_CREATED_AT);
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

        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME);
        $db = Propel::getServiceContainer()->getAdapter(ItemTableMap::DATABASE_NAME);

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
                || $this->getLimit()
                || $this->getHaving()
                || in_array(Criteria::DISTINCT, $this->getSelectModifiers());

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

} // ItemQuery
