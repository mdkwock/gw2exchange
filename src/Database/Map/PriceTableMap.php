<?php

namespace GW2Exchange\Database\Map;

use GW2Exchange\Database\Price;
use GW2Exchange\Database\PriceQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'price' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PriceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'GW2Exchange.Database.Map.PriceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gw2exchange';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'price';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\GW2Exchange\\Database\\Price';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'GW2Exchange.Database.Price';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'price.item_id';

    /**
     * the column name for the buy_price field
     */
    const COL_BUY_PRICE = 'price.buy_price';

    /**
     * the column name for the sell_price field
     */
    const COL_SELL_PRICE = 'price.sell_price';

    /**
     * the column name for the buy_qty field
     */
    const COL_BUY_QTY = 'price.buy_qty';

    /**
     * the column name for the sell_qty field
     */
    const COL_SELL_QTY = 'price.sell_qty';

    /**
     * the column name for the hash field
     */
    const COL_HASH = 'price.hash';

    /**
     * the column name for the profit field
     */
    const COL_PROFIT = 'price.profit';

    /**
     * the column name for the roi field
     */
    const COL_ROI = 'price.roi';

    /**
     * the column name for the cache_time field
     */
    const COL_CACHE_TIME = 'price.cache_time';

    /**
     * the column name for the max_buy field
     */
    const COL_MAX_BUY = 'price.max_buy';

    /**
     * the column name for the min_buy field
     */
    const COL_MIN_BUY = 'price.min_buy';

    /**
     * the column name for the max_sell field
     */
    const COL_MAX_SELL = 'price.max_sell';

    /**
     * the column name for the min_sell field
     */
    const COL_MIN_SELL = 'price.min_sell';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'price.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'price.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('ItemId', 'BuyPrice', 'SellPrice', 'BuyQty', 'SellQty', 'Hash', 'Profit', 'Roi', 'CacheTime', 'MaxBuy', 'MinBuy', 'MaxSell', 'MinSell', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('itemId', 'buyPrice', 'sellPrice', 'buyQty', 'sellQty', 'hash', 'profit', 'roi', 'cacheTime', 'maxBuy', 'minBuy', 'maxSell', 'minSell', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(PriceTableMap::COL_ITEM_ID, PriceTableMap::COL_BUY_PRICE, PriceTableMap::COL_SELL_PRICE, PriceTableMap::COL_BUY_QTY, PriceTableMap::COL_SELL_QTY, PriceTableMap::COL_HASH, PriceTableMap::COL_PROFIT, PriceTableMap::COL_ROI, PriceTableMap::COL_CACHE_TIME, PriceTableMap::COL_MAX_BUY, PriceTableMap::COL_MIN_BUY, PriceTableMap::COL_MAX_SELL, PriceTableMap::COL_MIN_SELL, PriceTableMap::COL_CREATED_AT, PriceTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('item_id', 'buy_price', 'sell_price', 'buy_qty', 'sell_qty', 'hash', 'profit', 'roi', 'cache_time', 'max_buy', 'min_buy', 'max_sell', 'min_sell', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ItemId' => 0, 'BuyPrice' => 1, 'SellPrice' => 2, 'BuyQty' => 3, 'SellQty' => 4, 'Hash' => 5, 'Profit' => 6, 'Roi' => 7, 'CacheTime' => 8, 'MaxBuy' => 9, 'MinBuy' => 10, 'MaxSell' => 11, 'MinSell' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, ),
        self::TYPE_CAMELNAME     => array('itemId' => 0, 'buyPrice' => 1, 'sellPrice' => 2, 'buyQty' => 3, 'sellQty' => 4, 'hash' => 5, 'profit' => 6, 'roi' => 7, 'cacheTime' => 8, 'maxBuy' => 9, 'minBuy' => 10, 'maxSell' => 11, 'minSell' => 12, 'createdAt' => 13, 'updatedAt' => 14, ),
        self::TYPE_COLNAME       => array(PriceTableMap::COL_ITEM_ID => 0, PriceTableMap::COL_BUY_PRICE => 1, PriceTableMap::COL_SELL_PRICE => 2, PriceTableMap::COL_BUY_QTY => 3, PriceTableMap::COL_SELL_QTY => 4, PriceTableMap::COL_HASH => 5, PriceTableMap::COL_PROFIT => 6, PriceTableMap::COL_ROI => 7, PriceTableMap::COL_CACHE_TIME => 8, PriceTableMap::COL_MAX_BUY => 9, PriceTableMap::COL_MIN_BUY => 10, PriceTableMap::COL_MAX_SELL => 11, PriceTableMap::COL_MIN_SELL => 12, PriceTableMap::COL_CREATED_AT => 13, PriceTableMap::COL_UPDATED_AT => 14, ),
        self::TYPE_FIELDNAME     => array('item_id' => 0, 'buy_price' => 1, 'sell_price' => 2, 'buy_qty' => 3, 'sell_qty' => 4, 'hash' => 5, 'profit' => 6, 'roi' => 7, 'cache_time' => 8, 'max_buy' => 9, 'min_buy' => 10, 'max_sell' => 11, 'min_sell' => 12, 'created_at' => 13, 'updated_at' => 14, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('price');
        $this->setPhpName('Price');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\GW2Exchange\\Database\\Price');
        $this->setPackage('GW2Exchange.Database');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('item_id', 'ItemId', 'INTEGER' , 'item', 'id', true, null, null);
        $this->addColumn('buy_price', 'BuyPrice', 'INTEGER', true, null, null);
        $this->addColumn('sell_price', 'SellPrice', 'INTEGER', true, null, null);
        $this->addColumn('buy_qty', 'BuyQty', 'INTEGER', true, null, null);
        $this->addColumn('sell_qty', 'SellQty', 'INTEGER', true, null, null);
        $this->addColumn('hash', 'Hash', 'VARCHAR', true, 128, null);
        $this->addColumn('profit', 'Profit', 'INTEGER', false, null, null);
        $this->addColumn('roi', 'Roi', 'FLOAT', false, null, null);
        $this->addColumn('cache_time', 'CacheTime', 'INTEGER', false, null, 4);
        $this->addColumn('max_buy', 'MaxBuy', 'INTEGER', false, null, null);
        $this->addColumn('min_buy', 'MinBuy', 'INTEGER', false, null, null);
        $this->addColumn('max_sell', 'MaxSell', 'INTEGER', false, null, null);
        $this->addColumn('min_sell', 'MinSell', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Item', '\\GW2Exchange\\Database\\Item', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PriceHistory', '\\GW2Exchange\\Database\\PriceHistory', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':item_id',
  ),
), null, null, 'PriceHistories', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
            'query_cache' => array('backend' => 'apc', 'lifetime' => '3600', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PriceTableMap::CLASS_DEFAULT : PriceTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Price object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PriceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PriceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PriceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PriceTableMap::OM_CLASS;
            /** @var Price $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PriceTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PriceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PriceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Price $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PriceTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PriceTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(PriceTableMap::COL_BUY_PRICE);
            $criteria->addSelectColumn(PriceTableMap::COL_SELL_PRICE);
            $criteria->addSelectColumn(PriceTableMap::COL_BUY_QTY);
            $criteria->addSelectColumn(PriceTableMap::COL_SELL_QTY);
            $criteria->addSelectColumn(PriceTableMap::COL_HASH);
            $criteria->addSelectColumn(PriceTableMap::COL_PROFIT);
            $criteria->addSelectColumn(PriceTableMap::COL_ROI);
            $criteria->addSelectColumn(PriceTableMap::COL_CACHE_TIME);
            $criteria->addSelectColumn(PriceTableMap::COL_MAX_BUY);
            $criteria->addSelectColumn(PriceTableMap::COL_MIN_BUY);
            $criteria->addSelectColumn(PriceTableMap::COL_MAX_SELL);
            $criteria->addSelectColumn(PriceTableMap::COL_MIN_SELL);
            $criteria->addSelectColumn(PriceTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PriceTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.buy_price');
            $criteria->addSelectColumn($alias . '.sell_price');
            $criteria->addSelectColumn($alias . '.buy_qty');
            $criteria->addSelectColumn($alias . '.sell_qty');
            $criteria->addSelectColumn($alias . '.hash');
            $criteria->addSelectColumn($alias . '.profit');
            $criteria->addSelectColumn($alias . '.roi');
            $criteria->addSelectColumn($alias . '.cache_time');
            $criteria->addSelectColumn($alias . '.max_buy');
            $criteria->addSelectColumn($alias . '.min_buy');
            $criteria->addSelectColumn($alias . '.max_sell');
            $criteria->addSelectColumn($alias . '.min_sell');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PriceTableMap::DATABASE_NAME)->getTable(PriceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PriceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PriceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PriceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Price or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Price object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \GW2Exchange\Database\Price) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PriceTableMap::DATABASE_NAME);
            $criteria->add(PriceTableMap::COL_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = PriceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PriceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PriceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the price table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PriceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Price or Criteria object.
     *
     * @param mixed               $criteria Criteria or Price object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Price object
        }


        // Set the correct dbName
        $query = PriceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PriceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PriceTableMap::buildTableMap();
