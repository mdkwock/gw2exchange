<?php

namespace GW2ledger\Database\Base;

use \Exception;
use \PDO;
use GW2ledger\Database\Listing as ChildListing;
use GW2ledger\Database\ListingQuery as ChildListingQuery;
use GW2ledger\Database\Map\ListingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'listing' table.
 *
 *
 *
 * @method     ChildListingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildListingQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildListingQuery orderByOrders($order = Criteria::ASC) Order by the orders column
 * @method     ChildListingQuery orderByUnitPrice($order = Criteria::ASC) Order by the unit_price column
 * @method     ChildListingQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildListingQuery groupById() Group by the id column
 * @method     ChildListingQuery groupByType() Group by the type column
 * @method     ChildListingQuery groupByOrders() Group by the orders column
 * @method     ChildListingQuery groupByUnitPrice() Group by the unit_price column
 * @method     ChildListingQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildListingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildListingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildListingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildListing findOne(ConnectionInterface $con = null) Return the first ChildListing matching the query
 * @method     ChildListing findOneOrCreate(ConnectionInterface $con = null) Return the first ChildListing matching the query, or a new ChildListing object populated from the query conditions when no match is found
 *
 * @method     ChildListing findOneById(int $id) Return the first ChildListing filtered by the id column
 * @method     ChildListing findOneByType(string $type) Return the first ChildListing filtered by the type column
 * @method     ChildListing findOneByOrders(int $orders) Return the first ChildListing filtered by the orders column
 * @method     ChildListing findOneByUnitPrice(int $unit_price) Return the first ChildListing filtered by the unit_price column
 * @method     ChildListing findOneByQuantity(int $quantity) Return the first ChildListing filtered by the quantity column *

 * @method     ChildListing requirePk($key, ConnectionInterface $con = null) Return the ChildListing by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListing requireOne(ConnectionInterface $con = null) Return the first ChildListing matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildListing requireOneById(int $id) Return the first ChildListing filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListing requireOneByType(string $type) Return the first ChildListing filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListing requireOneByOrders(int $orders) Return the first ChildListing filtered by the orders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListing requireOneByUnitPrice(int $unit_price) Return the first ChildListing filtered by the unit_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListing requireOneByQuantity(int $quantity) Return the first ChildListing filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildListing[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildListing objects based on current ModelCriteria
 * @method     ChildListing[]|ObjectCollection findById(int $id) Return ChildListing objects filtered by the id column
 * @method     ChildListing[]|ObjectCollection findByType(string $type) Return ChildListing objects filtered by the type column
 * @method     ChildListing[]|ObjectCollection findByOrders(int $orders) Return ChildListing objects filtered by the orders column
 * @method     ChildListing[]|ObjectCollection findByUnitPrice(int $unit_price) Return ChildListing objects filtered by the unit_price column
 * @method     ChildListing[]|ObjectCollection findByQuantity(int $quantity) Return ChildListing objects filtered by the quantity column
 * @method     ChildListing[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ListingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2ledger\Database\Base\ListingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2ledger', $modelName = '\\GW2ledger\\Database\\Listing', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildListingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildListingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildListingQuery) {
            return $criteria;
        }
        $query = new ChildListingQuery();
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
     * @return ChildListing|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ListingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ListingTableMap::DATABASE_NAME);
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
     * @return ChildListing A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, type, orders, unit_price, quantity FROM listing WHERE id = :p0';
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
            /** @var ChildListing $obj */
            $obj = new ChildListing();
            $obj->hydrate($row);
            ListingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildListing|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ListingTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ListingTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ListingTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ListingTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildListingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ListingTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function filterByOrders($orders = null, $comparison = null)
    {
        if (is_array($orders)) {
            $useMinMax = false;
            if (isset($orders['min'])) {
                $this->addUsingAlias(ListingTableMap::COL_ORDERS, $orders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orders['max'])) {
                $this->addUsingAlias(ListingTableMap::COL_ORDERS, $orders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingTableMap::COL_ORDERS, $orders, $comparison);
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
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function filterByUnitPrice($unitPrice = null, $comparison = null)
    {
        if (is_array($unitPrice)) {
            $useMinMax = false;
            if (isset($unitPrice['min'])) {
                $this->addUsingAlias(ListingTableMap::COL_UNIT_PRICE, $unitPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitPrice['max'])) {
                $this->addUsingAlias(ListingTableMap::COL_UNIT_PRICE, $unitPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingTableMap::COL_UNIT_PRICE, $unitPrice, $comparison);
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
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(ListingTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(ListingTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListingTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildListing $listing Object to remove from the list of results
     *
     * @return $this|ChildListingQuery The current query, for fluid interface
     */
    public function prune($listing = null)
    {
        if ($listing) {
            $this->addUsingAlias(ListingTableMap::COL_ID, $listing->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the listing table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ListingTableMap::clearInstancePool();
            ListingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ListingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ListingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ListingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ListingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ListingQuery
