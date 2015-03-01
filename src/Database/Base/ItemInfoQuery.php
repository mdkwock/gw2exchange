<?php

namespace Base;

use \ItemInfo as ChildItemInfo;
use \ItemInfoQuery as ChildItemInfoQuery;
use \Exception;
use \PDO;
use Map\ItemInfoTableMap;
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
 * @method     ChildItemInfoQuery orderByItemDescription($order = Criteria::ASC) Order by the item_description column
 * @method     ChildItemInfoQuery orderByItemType($order = Criteria::ASC) Order by the item_type column
 * @method     ChildItemInfoQuery orderByItemRarity($order = Criteria::ASC) Order by the item_rarity column
 * @method     ChildItemInfoQuery orderByItemLevel($order = Criteria::ASC) Order by the item_level column
 * @method     ChildItemInfoQuery orderByItemVendorValue($order = Criteria::ASC) Order by the item_vendor_value column
 * @method     ChildItemInfoQuery orderByItemDefaultSkin($order = Criteria::ASC) Order by the item_default_skin column
 * @method     ChildItemInfoQuery orderByItemFlags($order = Criteria::ASC) Order by the item_flags column
 * @method     ChildItemInfoQuery orderByItemGameTypes($order = Criteria::ASC) Order by the item_game_types column
 * @method     ChildItemInfoQuery orderByItemRestrictions($order = Criteria::ASC) Order by the item_restrictions column
 *
 * @method     ChildItemInfoQuery groupByItemId() Group by the item_id column
 * @method     ChildItemInfoQuery groupByItemDescription() Group by the item_description column
 * @method     ChildItemInfoQuery groupByItemType() Group by the item_type column
 * @method     ChildItemInfoQuery groupByItemRarity() Group by the item_rarity column
 * @method     ChildItemInfoQuery groupByItemLevel() Group by the item_level column
 * @method     ChildItemInfoQuery groupByItemVendorValue() Group by the item_vendor_value column
 * @method     ChildItemInfoQuery groupByItemDefaultSkin() Group by the item_default_skin column
 * @method     ChildItemInfoQuery groupByItemFlags() Group by the item_flags column
 * @method     ChildItemInfoQuery groupByItemGameTypes() Group by the item_game_types column
 * @method     ChildItemInfoQuery groupByItemRestrictions() Group by the item_restrictions column
 *
 * @method     ChildItemInfoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemInfoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemInfoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemInfoQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildItemInfoQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildItemInfoQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     \ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemInfo findOne(ConnectionInterface $con = null) Return the first ChildItemInfo matching the query
 * @method     ChildItemInfo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemInfo matching the query, or a new ChildItemInfo object populated from the query conditions when no match is found
 *
 * @method     ChildItemInfo findOneByItemId(int $item_id) Return the first ChildItemInfo filtered by the item_id column
 * @method     ChildItemInfo findOneByItemDescription(string $item_description) Return the first ChildItemInfo filtered by the item_description column
 * @method     ChildItemInfo findOneByItemType(string $item_type) Return the first ChildItemInfo filtered by the item_type column
 * @method     ChildItemInfo findOneByItemRarity(string $item_rarity) Return the first ChildItemInfo filtered by the item_rarity column
 * @method     ChildItemInfo findOneByItemLevel(int $item_level) Return the first ChildItemInfo filtered by the item_level column
 * @method     ChildItemInfo findOneByItemVendorValue(int $item_vendor_value) Return the first ChildItemInfo filtered by the item_vendor_value column
 * @method     ChildItemInfo findOneByItemDefaultSkin(int $item_default_skin) Return the first ChildItemInfo filtered by the item_default_skin column
 * @method     ChildItemInfo findOneByItemFlags(string $item_flags) Return the first ChildItemInfo filtered by the item_flags column
 * @method     ChildItemInfo findOneByItemGameTypes(string $item_game_types) Return the first ChildItemInfo filtered by the item_game_types column
 * @method     ChildItemInfo findOneByItemRestrictions(string $item_restrictions) Return the first ChildItemInfo filtered by the item_restrictions column *

 * @method     ChildItemInfo requirePk($key, ConnectionInterface $con = null) Return the ChildItemInfo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOne(ConnectionInterface $con = null) Return the first ChildItemInfo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemInfo requireOneByItemId(int $item_id) Return the first ChildItemInfo filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemDescription(string $item_description) Return the first ChildItemInfo filtered by the item_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemType(string $item_type) Return the first ChildItemInfo filtered by the item_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemRarity(string $item_rarity) Return the first ChildItemInfo filtered by the item_rarity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemLevel(int $item_level) Return the first ChildItemInfo filtered by the item_level column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemVendorValue(int $item_vendor_value) Return the first ChildItemInfo filtered by the item_vendor_value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemDefaultSkin(int $item_default_skin) Return the first ChildItemInfo filtered by the item_default_skin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemFlags(string $item_flags) Return the first ChildItemInfo filtered by the item_flags column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemGameTypes(string $item_game_types) Return the first ChildItemInfo filtered by the item_game_types column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemInfo requireOneByItemRestrictions(string $item_restrictions) Return the first ChildItemInfo filtered by the item_restrictions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemInfo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemInfo objects based on current ModelCriteria
 * @method     ChildItemInfo[]|ObjectCollection findByItemId(int $item_id) Return ChildItemInfo objects filtered by the item_id column
 * @method     ChildItemInfo[]|ObjectCollection findByItemDescription(string $item_description) Return ChildItemInfo objects filtered by the item_description column
 * @method     ChildItemInfo[]|ObjectCollection findByItemType(string $item_type) Return ChildItemInfo objects filtered by the item_type column
 * @method     ChildItemInfo[]|ObjectCollection findByItemRarity(string $item_rarity) Return ChildItemInfo objects filtered by the item_rarity column
 * @method     ChildItemInfo[]|ObjectCollection findByItemLevel(int $item_level) Return ChildItemInfo objects filtered by the item_level column
 * @method     ChildItemInfo[]|ObjectCollection findByItemVendorValue(int $item_vendor_value) Return ChildItemInfo objects filtered by the item_vendor_value column
 * @method     ChildItemInfo[]|ObjectCollection findByItemDefaultSkin(int $item_default_skin) Return ChildItemInfo objects filtered by the item_default_skin column
 * @method     ChildItemInfo[]|ObjectCollection findByItemFlags(string $item_flags) Return ChildItemInfo objects filtered by the item_flags column
 * @method     ChildItemInfo[]|ObjectCollection findByItemGameTypes(string $item_game_types) Return ChildItemInfo objects filtered by the item_game_types column
 * @method     ChildItemInfo[]|ObjectCollection findByItemRestrictions(string $item_restrictions) Return ChildItemInfo objects filtered by the item_restrictions column
 * @method     ChildItemInfo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemInfoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ItemInfoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2ledger', $modelName = '\\ItemInfo', $modelAlias = null)
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
        $sql = 'SELECT item_id, item_description, item_type, item_rarity, item_level, item_vendor_value, item_default_skin, item_flags, item_game_types, item_restrictions FROM item_info WHERE item_id = :p0';
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
     * Filter the query on the item_description column
     *
     * Example usage:
     * <code>
     * $query->filterByItemDescription('fooValue');   // WHERE item_description = 'fooValue'
     * $query->filterByItemDescription('%fooValue%'); // WHERE item_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemDescription($itemDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemDescription)) {
                $itemDescription = str_replace('*', '%', $itemDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_DESCRIPTION, $itemDescription, $comparison);
    }

    /**
     * Filter the query on the item_type column
     *
     * Example usage:
     * <code>
     * $query->filterByItemType('fooValue');   // WHERE item_type = 'fooValue'
     * $query->filterByItemType('%fooValue%'); // WHERE item_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemType($itemType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemType)) {
                $itemType = str_replace('*', '%', $itemType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_TYPE, $itemType, $comparison);
    }

    /**
     * Filter the query on the item_rarity column
     *
     * Example usage:
     * <code>
     * $query->filterByItemRarity('fooValue');   // WHERE item_rarity = 'fooValue'
     * $query->filterByItemRarity('%fooValue%'); // WHERE item_rarity LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemRarity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemRarity($itemRarity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemRarity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemRarity)) {
                $itemRarity = str_replace('*', '%', $itemRarity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_RARITY, $itemRarity, $comparison);
    }

    /**
     * Filter the query on the item_level column
     *
     * Example usage:
     * <code>
     * $query->filterByItemLevel(1234); // WHERE item_level = 1234
     * $query->filterByItemLevel(array(12, 34)); // WHERE item_level IN (12, 34)
     * $query->filterByItemLevel(array('min' => 12)); // WHERE item_level > 12
     * </code>
     *
     * @param     mixed $itemLevel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemLevel($itemLevel = null, $comparison = null)
    {
        if (is_array($itemLevel)) {
            $useMinMax = false;
            if (isset($itemLevel['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_LEVEL, $itemLevel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemLevel['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_LEVEL, $itemLevel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_LEVEL, $itemLevel, $comparison);
    }

    /**
     * Filter the query on the item_vendor_value column
     *
     * Example usage:
     * <code>
     * $query->filterByItemVendorValue(1234); // WHERE item_vendor_value = 1234
     * $query->filterByItemVendorValue(array(12, 34)); // WHERE item_vendor_value IN (12, 34)
     * $query->filterByItemVendorValue(array('min' => 12)); // WHERE item_vendor_value > 12
     * </code>
     *
     * @param     mixed $itemVendorValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemVendorValue($itemVendorValue = null, $comparison = null)
    {
        if (is_array($itemVendorValue)) {
            $useMinMax = false;
            if (isset($itemVendorValue['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_VENDOR_VALUE, $itemVendorValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemVendorValue['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_VENDOR_VALUE, $itemVendorValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_VENDOR_VALUE, $itemVendorValue, $comparison);
    }

    /**
     * Filter the query on the item_default_skin column
     *
     * Example usage:
     * <code>
     * $query->filterByItemDefaultSkin(1234); // WHERE item_default_skin = 1234
     * $query->filterByItemDefaultSkin(array(12, 34)); // WHERE item_default_skin IN (12, 34)
     * $query->filterByItemDefaultSkin(array('min' => 12)); // WHERE item_default_skin > 12
     * </code>
     *
     * @param     mixed $itemDefaultSkin The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemDefaultSkin($itemDefaultSkin = null, $comparison = null)
    {
        if (is_array($itemDefaultSkin)) {
            $useMinMax = false;
            if (isset($itemDefaultSkin['min'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN, $itemDefaultSkin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemDefaultSkin['max'])) {
                $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN, $itemDefaultSkin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN, $itemDefaultSkin, $comparison);
    }

    /**
     * Filter the query on the item_flags column
     *
     * Example usage:
     * <code>
     * $query->filterByItemFlags('fooValue');   // WHERE item_flags = 'fooValue'
     * $query->filterByItemFlags('%fooValue%'); // WHERE item_flags LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemFlags The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemFlags($itemFlags = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemFlags)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemFlags)) {
                $itemFlags = str_replace('*', '%', $itemFlags);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_FLAGS, $itemFlags, $comparison);
    }

    /**
     * Filter the query on the item_game_types column
     *
     * Example usage:
     * <code>
     * $query->filterByItemGameTypes('fooValue');   // WHERE item_game_types = 'fooValue'
     * $query->filterByItemGameTypes('%fooValue%'); // WHERE item_game_types LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemGameTypes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemGameTypes($itemGameTypes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemGameTypes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemGameTypes)) {
                $itemGameTypes = str_replace('*', '%', $itemGameTypes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_GAME_TYPES, $itemGameTypes, $comparison);
    }

    /**
     * Filter the query on the item_restrictions column
     *
     * Example usage:
     * <code>
     * $query->filterByItemRestrictions('fooValue');   // WHERE item_restrictions = 'fooValue'
     * $query->filterByItemRestrictions('%fooValue%'); // WHERE item_restrictions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemRestrictions The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItemRestrictions($itemRestrictions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemRestrictions)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemRestrictions)) {
                $itemRestrictions = str_replace('*', '%', $itemRestrictions);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemInfoTableMap::COL_ITEM_RESTRICTIONS, $itemRestrictions, $comparison);
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemInfoQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemInfoTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
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

} // ItemInfoQuery
