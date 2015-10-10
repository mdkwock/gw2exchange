<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\PriceRequestLogEntry as ChildPriceRequestLogEntry;
use GW2Exchange\Database\PriceRequestLogEntryQuery as ChildPriceRequestLogEntryQuery;
use GW2Exchange\Database\Map\PriceRequestLogEntryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'price_request_log_entry' table.
 *
 *
 *
 * @method     ChildPriceRequestLogEntryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPriceRequestLogEntryQuery orderByPriceHistoryId($order = Criteria::ASC) Order by the price_history_id column
 * @method     ChildPriceRequestLogEntryQuery orderByCacheHit($order = Criteria::ASC) Order by the cache_hit column
 * @method     ChildPriceRequestLogEntryQuery orderByCacheCorrect($order = Criteria::ASC) Order by the cache_correct column
 * @method     ChildPriceRequestLogEntryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildPriceRequestLogEntryQuery groupById() Group by the id column
 * @method     ChildPriceRequestLogEntryQuery groupByPriceHistoryId() Group by the price_history_id column
 * @method     ChildPriceRequestLogEntryQuery groupByCacheHit() Group by the cache_hit column
 * @method     ChildPriceRequestLogEntryQuery groupByCacheCorrect() Group by the cache_correct column
 * @method     ChildPriceRequestLogEntryQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildPriceRequestLogEntryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPriceRequestLogEntryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPriceRequestLogEntryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPriceRequestLogEntryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPriceRequestLogEntryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPriceRequestLogEntryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPriceRequestLogEntryQuery leftJoinPriceHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the PriceHistory relation
 * @method     ChildPriceRequestLogEntryQuery rightJoinPriceHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PriceHistory relation
 * @method     ChildPriceRequestLogEntryQuery innerJoinPriceHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the PriceHistory relation
 *
 * @method     ChildPriceRequestLogEntryQuery joinWithPriceHistory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PriceHistory relation
 *
 * @method     ChildPriceRequestLogEntryQuery leftJoinWithPriceHistory() Adds a LEFT JOIN clause and with to the query using the PriceHistory relation
 * @method     ChildPriceRequestLogEntryQuery rightJoinWithPriceHistory() Adds a RIGHT JOIN clause and with to the query using the PriceHistory relation
 * @method     ChildPriceRequestLogEntryQuery innerJoinWithPriceHistory() Adds a INNER JOIN clause and with to the query using the PriceHistory relation
 *
 * @method     \GW2Exchange\Database\PriceHistoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPriceRequestLogEntry findOne(ConnectionInterface $con = null) Return the first ChildPriceRequestLogEntry matching the query
 * @method     ChildPriceRequestLogEntry findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPriceRequestLogEntry matching the query, or a new ChildPriceRequestLogEntry object populated from the query conditions when no match is found
 *
 * @method     ChildPriceRequestLogEntry findOneById(int $id) Return the first ChildPriceRequestLogEntry filtered by the id column
 * @method     ChildPriceRequestLogEntry findOneByPriceHistoryId(int $price_history_id) Return the first ChildPriceRequestLogEntry filtered by the price_history_id column
 * @method     ChildPriceRequestLogEntry findOneByCacheHit(int $cache_hit) Return the first ChildPriceRequestLogEntry filtered by the cache_hit column
 * @method     ChildPriceRequestLogEntry findOneByCacheCorrect(int $cache_correct) Return the first ChildPriceRequestLogEntry filtered by the cache_correct column
 * @method     ChildPriceRequestLogEntry findOneByCreatedAt(string $created_at) Return the first ChildPriceRequestLogEntry filtered by the created_at column *

 * @method     ChildPriceRequestLogEntry requirePk($key, ConnectionInterface $con = null) Return the ChildPriceRequestLogEntry by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceRequestLogEntry requireOne(ConnectionInterface $con = null) Return the first ChildPriceRequestLogEntry matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPriceRequestLogEntry requireOneById(int $id) Return the first ChildPriceRequestLogEntry filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceRequestLogEntry requireOneByPriceHistoryId(int $price_history_id) Return the first ChildPriceRequestLogEntry filtered by the price_history_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceRequestLogEntry requireOneByCacheHit(int $cache_hit) Return the first ChildPriceRequestLogEntry filtered by the cache_hit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceRequestLogEntry requireOneByCacheCorrect(int $cache_correct) Return the first ChildPriceRequestLogEntry filtered by the cache_correct column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPriceRequestLogEntry requireOneByCreatedAt(string $created_at) Return the first ChildPriceRequestLogEntry filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPriceRequestLogEntry[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPriceRequestLogEntry objects based on current ModelCriteria
 * @method     ChildPriceRequestLogEntry[]|ObjectCollection findById(int $id) Return ChildPriceRequestLogEntry objects filtered by the id column
 * @method     ChildPriceRequestLogEntry[]|ObjectCollection findByPriceHistoryId(int $price_history_id) Return ChildPriceRequestLogEntry objects filtered by the price_history_id column
 * @method     ChildPriceRequestLogEntry[]|ObjectCollection findByCacheHit(int $cache_hit) Return ChildPriceRequestLogEntry objects filtered by the cache_hit column
 * @method     ChildPriceRequestLogEntry[]|ObjectCollection findByCacheCorrect(int $cache_correct) Return ChildPriceRequestLogEntry objects filtered by the cache_correct column
 * @method     ChildPriceRequestLogEntry[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPriceRequestLogEntry objects filtered by the created_at column
 * @method     ChildPriceRequestLogEntry[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PriceRequestLogEntryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\PriceRequestLogEntryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2exchange', $modelName = '\\GW2Exchange\\Database\\PriceRequestLogEntry', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPriceRequestLogEntryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPriceRequestLogEntryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPriceRequestLogEntryQuery) {
            return $criteria;
        }
        $query = new ChildPriceRequestLogEntryQuery();
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
     * @return ChildPriceRequestLogEntry|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PriceRequestLogEntryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PriceRequestLogEntryTableMap::DATABASE_NAME);
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
     * @return ChildPriceRequestLogEntry A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, price_history_id, cache_hit, cache_correct, created_at FROM price_request_log_entry WHERE id = :p0';
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
            /** @var ChildPriceRequestLogEntry $obj */
            $obj = new ChildPriceRequestLogEntry();
            $obj->hydrate($row);
            PriceRequestLogEntryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPriceRequestLogEntry|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the price_history_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceHistoryId(1234); // WHERE price_history_id = 1234
     * $query->filterByPriceHistoryId(array(12, 34)); // WHERE price_history_id IN (12, 34)
     * $query->filterByPriceHistoryId(array('min' => 12)); // WHERE price_history_id > 12
     * </code>
     *
     * @see       filterByPriceHistory()
     *
     * @param     mixed $priceHistoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByPriceHistoryId($priceHistoryId = null, $comparison = null)
    {
        if (is_array($priceHistoryId)) {
            $useMinMax = false;
            if (isset($priceHistoryId['min'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_PRICE_HISTORY_ID, $priceHistoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceHistoryId['max'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_PRICE_HISTORY_ID, $priceHistoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_PRICE_HISTORY_ID, $priceHistoryId, $comparison);
    }

    /**
     * Filter the query on the cache_hit column
     *
     * Example usage:
     * <code>
     * $query->filterByCacheHit(1234); // WHERE cache_hit = 1234
     * $query->filterByCacheHit(array(12, 34)); // WHERE cache_hit IN (12, 34)
     * $query->filterByCacheHit(array('min' => 12)); // WHERE cache_hit > 12
     * </code>
     *
     * @param     mixed $cacheHit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByCacheHit($cacheHit = null, $comparison = null)
    {
        if (is_array($cacheHit)) {
            $useMinMax = false;
            if (isset($cacheHit['min'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CACHE_HIT, $cacheHit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cacheHit['max'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CACHE_HIT, $cacheHit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CACHE_HIT, $cacheHit, $comparison);
    }

    /**
     * Filter the query on the cache_correct column
     *
     * Example usage:
     * <code>
     * $query->filterByCacheCorrect(1234); // WHERE cache_correct = 1234
     * $query->filterByCacheCorrect(array(12, 34)); // WHERE cache_correct IN (12, 34)
     * $query->filterByCacheCorrect(array('min' => 12)); // WHERE cache_correct > 12
     * </code>
     *
     * @param     mixed $cacheCorrect The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByCacheCorrect($cacheCorrect = null, $comparison = null)
    {
        if (is_array($cacheCorrect)) {
            $useMinMax = false;
            if (isset($cacheCorrect['min'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CACHE_CORRECT, $cacheCorrect['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cacheCorrect['max'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CACHE_CORRECT, $cacheCorrect['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CACHE_CORRECT, $cacheCorrect, $comparison);
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
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\PriceHistory object
     *
     * @param \GW2Exchange\Database\PriceHistory|ObjectCollection $priceHistory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function filterByPriceHistory($priceHistory, $comparison = null)
    {
        if ($priceHistory instanceof \GW2Exchange\Database\PriceHistory) {
            return $this
                ->addUsingAlias(PriceRequestLogEntryTableMap::COL_PRICE_HISTORY_ID, $priceHistory->getId(), $comparison);
        } elseif ($priceHistory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PriceRequestLogEntryTableMap::COL_PRICE_HISTORY_ID, $priceHistory->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
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
     * @param   ChildPriceRequestLogEntry $priceRequestLogEntry Object to remove from the list of results
     *
     * @return $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function prune($priceRequestLogEntry = null)
    {
        if ($priceRequestLogEntry) {
            $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_ID, $priceRequestLogEntry->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the price_request_log_entry table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceRequestLogEntryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PriceRequestLogEntryTableMap::clearInstancePool();
            PriceRequestLogEntryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceRequestLogEntryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PriceRequestLogEntryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PriceRequestLogEntryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PriceRequestLogEntryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PriceRequestLogEntryTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PriceRequestLogEntryTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPriceRequestLogEntryQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PriceRequestLogEntryTableMap::COL_CREATED_AT);
    }

} // PriceRequestLogEntryQuery
