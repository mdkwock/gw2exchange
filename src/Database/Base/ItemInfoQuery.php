<?php

namespace GW2Exchange\Database\Base;

use \Exception;
use \PDO;
use GW2Exchange\Database\ItemInfo as ChildItemInfo;
use GW2Exchange\Database\ItemInfoQuery as ChildItemInfoQuery;
use GW2Exchange\Database\Map\ItemInfoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item_info' table.
 *
 *
 *
 * @method     ChildItemInfoQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemInfoQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildItemInfoQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildItemInfoQuery orderByRarity($order = Criteria::ASC) Order by the rarity column
 * @method     ChildItemInfoQuery orderByLevel($order = Criteria::ASC) Order by the level column
 * @method     ChildItemInfoQuery orderByVendorValue($order = Criteria::ASC) Order by the vendor_value column
 * @method     ChildItemInfoQuery orderByDefaultSkin($order = Criteria::ASC) Order by the default_skin column
 * @method     ChildItemInfoQuery orderByFlags($order = Criteria::ASC) Order by the flags column
 * @method     ChildItemInfoQuery orderByGameTypes($order = Criteria::ASC) Order by the game_types column
 * @method     ChildItemInfoQuery orderByRestrictions($order = Criteria::ASC) Order by the restrictions column
 *
 * @method     ChildItemInfoQuery groupByItemId() Group by the item_id column
 * @method     ChildItemInfoQuery groupByDescription() Group by the description column
 * @method     ChildItemInfoQuery groupByType() Group by the type column
 * @method     ChildItemInfoQuery groupByRarity() Group by the rarity column
 * @method     ChildItemInfoQuery groupByLevel() Group by the level column
 * @method     ChildItemInfoQuery groupByVendorValue() Group by the vendor_value column
 * @method     ChildItemInfoQuery groupByDefaultSkin() Group by the default_skin column
 * @method     ChildItemInfoQuery groupByFlags() Group by the flags column
 * @method     ChildItemInfoQuery groupByGameTypes() Group by the game_types column
 * @method     ChildItemInfoQuery groupByRestrictions() Group by the restrictions column
 *
 * @method     ChildItemInfoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemInfoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemInfoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemInfoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemInfoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemInfoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemInfoQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildItemInfoQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildItemInfoQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildItemInfoQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildItemInfoQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildItemInfoQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildItemInfoQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     \GW2Exchange\Database\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemInfo findOne(ConnectionInterface $con = null) Return the first ChildItemInfo matching the query
 * @method     ChildItemInfo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemInfo matching the query, or a new ChildItemInfo object populated from the query conditions when no match is found
 *
 * @method     ChildItemInfo findOneByItemId(int $item_id) Return the first ChildItemInfo filtered by the item_id column
 * @method     ChildItemInfo findOneByDescription(string $description) Return the first ChildItemInfo filtered by the description column
 * @method     ChildItemInfo findOneByType(string $type) Return the first ChildItemInfo filtered by the type column
 * @method     ChildItemInfo findOneByRarity(string $rarity) Return the first ChildItemInfo filtered by the rarity column
 * @method     ChildItemInfo findOneByLevel(int $level) Return the first ChildItemInfo filtered by the level column
 * @method     ChildItemInfo findOneByVendorValue(int $vendor_value) Return the first ChildItemInfo filtered by the vendor_value column
 * @method     ChildItemInfo findOneByDefaultSkin(int $default_skin) Return the first ChildItemInfo filtered by the default_skin column
 * @method     ChildItemInfo findOneByFlags(string $flags) Return the first ChildItemInfo filtered by the flags column
 * @method     ChildItemInfo findOneByGameTypes(string $game_types) Return the first ChildItemInfo filtered by the game_types column
 * @method     ChildItemInfo findOneByRestrictions(string $restrictions) Return the first ChildItemInfo filtered by the restrictions column *

 * @method     ChildItemInfo requirePk($key, ConnectionInterface $con = null) Return the ChildItemInfo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOne(ConnectionInterface $con = null) Return the first ChildItemInfo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemInfo requireOneByItemId(int $item_id) Return the first ChildItemInfo filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByDescription(string $description) Return the first ChildItemInfo filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByType(string $type) Return the first ChildItemInfo filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByRarity(string $rarity) Return the first ChildItemInfo filtered by the rarity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByLevel(int $level) Return the first ChildItemInfo filtered by the level column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByVendorValue(int $vendor_value) Return the first ChildItemInfo filtered by the vendor_value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByDefaultSkin(int $default_skin) Return the first ChildItemInfo filtered by the default_skin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByFlags(string $flags) Return the first ChildItemInfo filtered by the flags column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByGameTypes(string $game_types) Return the first ChildItemInfo filtered by the game_types column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByRestrictions(string $restrictions) Return the first ChildItemInfo filtered by the restrictions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemInfo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemInfo objects based on current ModelCriteria
 * @method     ChildItemInfo[]|ObjectCollection findByItemId(int $item_id) Return ChildItemInfo objects filtered by the item_id column
 * @method     ChildItemInfo[]|ObjectCollection findByDescription(string $description) Return ChildItemInfo objects filtered by the description column
 * @method     ChildItemInfo[]|ObjectCollection findByType(string $type) Return ChildItemInfo objects filtered by the type column
 * @method     ChildItemInfo[]|ObjectCollection findByRarity(string $rarity) Return ChildItemInfo objects filtered by the rarity column
 * @method     ChildItemInfo[]|ObjectCollection findByLevel(int $level) Return ChildItemInfo objects filtered by the level column
 * @method     ChildItemInfo[]|ObjectCollection findByVendorValue(int $vendor_value) Return ChildItemInfo objects filtered by the vendor_value column
 * @method     ChildItemInfo[]|ObjectCollection findByDefaultSkin(int $default_skin) Return ChildItemInfo objects filtered by the default_skin column
 * @method     ChildItemInfo[]|ObjectCollection findByFlags(string $flags) Return ChildItemInfo objects filtered by the flags column
 * @method     ChildItemInfo[]|ObjectCollection findByGameTypes(string $game_types) Return ChildItemInfo objects filtered by the game_types column
 * @method     ChildItemInfo[]|ObjectCollection findByRestrictions(string $restrictions) Return ChildItemInfo objects filtered by the restrictions column
 * @method     ChildItemInfo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemInfoQuery extends ModelCriteria
{

    // query_cache behavior
    protected $queryKey = '';
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \GW2Exchange\Database\Base\ItemInfoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2exchange', $modelName = '\\GW2Exchange\\Database\\ItemInfo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemInfoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemInfoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemInfoQuery) {
            return $criteria;
        }
        $query = new ChildItemInfoQuery();
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
     * @return ChildItemInfo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemInfoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemInfoTableMap::DATABASE_NAME);
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
     * @return ChildItemInfo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, description, type, rarity, level, vendor_value, default_skin, flags, game_types, restrictions FROM item_info WHERE item_id = :p0';
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
            /** @var ChildItemInfo $obj */
            $obj = new ChildItemInfo();
            $obj->hydrate($row);
            ItemInfoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItemInfo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ItemInfoTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the rarity column
     *
     * Example usage:
     * <code>
     * $query->filterByRarity('fooValue');   // WHERE rarity = 'fooValue'
     * $query->filterByRarity('%fooValue%'); // WHERE rarity LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rarity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByRarity($rarity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rarity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rarity)) {
                $rarity = str_replace('*', '%', $rarity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_RARITY, $rarity, $comparison);
    }

    /**
     * Filter the query on the level column
     *
     * Example usage:
     * <code>
     * $query->filterByLevel(1234); // WHERE level = 1234
     * $query->filterByLevel(array(12, 34)); // WHERE level IN (12, 34)
     * $query->filterByLevel(array('min' => 12)); // WHERE level > 12
     * </code>
     *
     * @param     mixed $level The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByLevel($level = null, $comparison = null)
    {
        if (is_array($level)) {
            $useMinMax = false;
            if (isset($level['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_LEVEL, $level['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($level['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_LEVEL, $level['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_LEVEL, $level, $comparison);
    }

    /**
     * Filter the query on the vendor_value column
     *
     * Example usage:
     * <code>
     * $query->filterByVendorValue(1234); // WHERE vendor_value = 1234
     * $query->filterByVendorValue(array(12, 34)); // WHERE vendor_value IN (12, 34)
     * $query->filterByVendorValue(array('min' => 12)); // WHERE vendor_value > 12
     * </code>
     *
     * @param     mixed $vendorValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByVendorValue($vendorValue = null, $comparison = null)
    {
        if (is_array($vendorValue)) {
            $useMinMax = false;
            if (isset($vendorValue['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_VENDOR_VALUE, $vendorValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vendorValue['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_VENDOR_VALUE, $vendorValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_VENDOR_VALUE, $vendorValue, $comparison);
    }

    /**
     * Filter the query on the default_skin column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultSkin(1234); // WHERE default_skin = 1234
     * $query->filterByDefaultSkin(array(12, 34)); // WHERE default_skin IN (12, 34)
     * $query->filterByDefaultSkin(array('min' => 12)); // WHERE default_skin > 12
     * </code>
     *
     * @param     mixed $defaultSkin The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByDefaultSkin($defaultSkin = null, $comparison = null)
    {
        if (is_array($defaultSkin)) {
            $useMinMax = false;
            if (isset($defaultSkin['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_DEFAULT_SKIN, $defaultSkin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultSkin['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_DEFAULT_SKIN, $defaultSkin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_DEFAULT_SKIN, $defaultSkin, $comparison);
    }

    /**
     * Filter the query on the flags column
     *
     * Example usage:
     * <code>
     * $query->filterByFlags('fooValue');   // WHERE flags = 'fooValue'
     * $query->filterByFlags('%fooValue%'); // WHERE flags LIKE '%fooValue%'
     * </code>
     *
     * @param     string $flags The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByFlags($flags = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($flags)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $flags)) {
                $flags = str_replace('*', '%', $flags);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_FLAGS, $flags, $comparison);
    }

    /**
     * Filter the query on the game_types column
     *
     * Example usage:
     * <code>
     * $query->filterByGameTypes('fooValue');   // WHERE game_types = 'fooValue'
     * $query->filterByGameTypes('%fooValue%'); // WHERE game_types LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gameTypes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByGameTypes($gameTypes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gameTypes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gameTypes)) {
                $gameTypes = str_replace('*', '%', $gameTypes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_GAME_TYPES, $gameTypes, $comparison);
    }

    /**
     * Filter the query on the restrictions column
     *
     * Example usage:
     * <code>
     * $query->filterByRestrictions('fooValue');   // WHERE restrictions = 'fooValue'
     * $query->filterByRestrictions('%fooValue%'); // WHERE restrictions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $restrictions The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByRestrictions($restrictions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($restrictions)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $restrictions)) {
                $restrictions = str_replace('*', '%', $restrictions);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_RESTRICTIONS, $restrictions, $comparison);
    }

    /**
     * Filter the query by a related \GW2Exchange\Database\Item object
     *
     * @param \GW2Exchange\Database\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \GW2Exchange\Database\Item) {
            return $this
                ->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildItemInfo $itemInfo Object to remove from the list of results
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function prune($itemInfo = null)
    {
        if ($itemInfo) {
            $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $itemInfo->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item_info table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemInfoTableMap::clearInstancePool();
            ItemInfoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemInfoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemInfoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemInfoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
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

        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemInfoTableMap::DATABASE_NAME);
        $db = Propel::getServiceContainer()->getAdapter(ItemInfoTableMap::DATABASE_NAME);

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

} // ItemInfoQuery
