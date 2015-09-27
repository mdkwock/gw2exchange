<?php

namespace GW2Exchange\Database\Map;

use GW2Exchange\Database\PriceHistory;
use GW2Exchange\Database\PriceHistoryQuery;
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
 * This class defines the structure of the 'price_history' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PriceHistoryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'GW2Exchange.Database.Map.PriceHistoryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gw2exchange';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'price_history';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\GW2Exchange\\Database\\PriceHistory';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'GW2Exchange.Database.PriceHistory';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'price_history.id';

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'price_history.item_id';

    /**
     * the column name for the buy_price field
     */
    const COL_BUY_PRICE = 'price_history.buy_price';

    /**
     * the column name for the sell_price field
     */
    const COL_SELL_PRICE = 'price_history.sell_price';

    /**
     * the column name for the buy_qty field
     */
    const COL_BUY_QTY = 'price_history.buy_qty';

    /**
     * the column name for the sell_qty field
     */
    const COL_SELL_QTY = 'price_history.sell_qty';

    /**
     * the column name for the hash field
     */
    const COL_HASH = 'price_history.hash';

    /**
     * the column name for the profit field
     */
    const COL_PROFIT = 'price_history.profit';

    /**
     * the column name for the roi field
     */
    const COL_ROI = 'price_history.roi';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'price_history.created_at';

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
        self::TYPE_PHPNAME       => array('Id', 'ItemId', 'BuyPrice', 'SellPrice', 'BuyQty', 'SellQty', 'Hash', 'Profit', 'Roi', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'itemId', 'buyPrice', 'sellPrice', 'buyQty', 'sellQty', 'hash', 'profit', 'roi', 'createdAt', ),
        self::TYPE_COLNAME       => array(PriceHistoryTableMap::COL_ID, PriceHistoryTableMap::COL_ITEM_ID, PriceHistoryTableMap::COL_BUY_PRICE, PriceHistoryTableMap::COL_SELL_PRICE, PriceHistoryTableMap::COL_BUY_QTY, PriceHistoryTableMap::COL_SELL_QTY, PriceHistoryTableMap::COL_HASH, PriceHistoryTableMap::COL_PROFIT, PriceHistoryTableMap::COL_ROI, PriceHistoryTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'item_id', 'buy_price', 'sell_price', 'buy_qty', 'sell_qty', 'hash', 'profit', 'roi', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ItemId' => 1, 'BuyPrice' => 2, 'SellPrice' => 3, 'BuyQty' => 4, 'SellQty' => 5, 'Hash' => 6, 'Profit' => 7, 'Roi' => 8, 'CreatedAt' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'itemId' => 1, 'buyPrice' => 2, 'sellPrice' => 3, 'buyQty' => 4, 'sellQty' => 5, 'hash' => 6, 'profit' => 7, 'roi' => 8, 'createdAt' => 9, ),
        self::TYPE_COLNAME       => array(PriceHistoryTableMap::COL_ID => 0, PriceHistoryTableMap::COL_ITEM_ID => 1, PriceHistoryTableMap::COL_BUY_PRICE => 2, PriceHistoryTableMap::COL_SELL_PRICE => 3, PriceHistoryTableMap::COL_BUY_QTY => 4, PriceHistoryTableMap::COL_SELL_QTY => 5, PriceHistoryTableMap::COL_HASH => 6, PriceHistoryTableMap::COL_PROFIT => 7, PriceHistoryTableMap::COL_ROI => 8, PriceHistoryTableMap::COL_CREATED_AT => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'item_id' => 1, 'buy_price' => 2, 'sell_price' => 3, 'buy_qty' => 4, 'sell_qty' => 5, 'hash' => 6, 'profit' => 7, 'roi' => 8, 'created_at' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('price_history');
        $this->setPhpName('PriceHistory');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\GW2Exchange\\Database\\PriceHistory');
        $this->setPackage('GW2Exchange.Database');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('item_id', 'ItemId', 'INTEGER', 'item', 'id', true, null, null);
        $this->addForeignKey('item_id', 'ItemId', 'INTEGER', 'price', 'item_id', true, null, null);
        $this->addColumn('buy_price', 'BuyPrice', 'INTEGER', true, null, null);
        $this->addColumn('sell_price', 'SellPrice', 'INTEGER', true, null, null);
        $this->addColumn('buy_qty', 'BuyQty', 'INTEGER', true, null, null);
        $this->addColumn('sell_qty', 'SellQty', 'INTEGER', true, null, null);
        $this->addColumn('hash', 'Hash', 'VARCHAR', true, 128, null);
        $this->addColumn('profit', 'Profit', 'INTEGER', false, null, null);
        $this->addColumn('roi', 'Roi', 'FLOAT', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
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
        $this->addRelation('Price', '\\GW2Exchange\\Database\\Price', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':item_id',
  ),
), null, null, null, false);
        $this->addRelation('RequestsLog', '\\GW2Exchange\\Database\\RequestsLog', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':price_history_id',
    1 => ':id',
  ),
), null, null, 'RequestsLogs', false);
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
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'true', ),
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PriceHistoryTableMap::CLASS_DEFAULT : PriceHistoryTableMap::OM_CLASS;
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
     * @return array           (PriceHistory object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PriceHistoryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PriceHistoryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PriceHistoryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PriceHistoryTableMap::OM_CLASS;
            /** @var PriceHistory $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PriceHistoryTableMap::addInstanceToPool($obj, $key);
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
            $key = PriceHistoryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PriceHistoryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PriceHistory $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PriceHistoryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_ID);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_BUY_PRICE);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_SELL_PRICE);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_BUY_QTY);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_SELL_QTY);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_HASH);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_PROFIT);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_ROI);
            $criteria->addSelectColumn(PriceHistoryTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.buy_price');
            $criteria->addSelectColumn($alias . '.sell_price');
            $criteria->addSelectColumn($alias . '.buy_qty');
            $criteria->addSelectColumn($alias . '.sell_qty');
            $criteria->addSelectColumn($alias . '.hash');
            $criteria->addSelectColumn($alias . '.profit');
            $criteria->addSelectColumn($alias . '.roi');
            $criteria->addSelectColumn($alias . '.created_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(PriceHistoryTableMap::DATABASE_NAME)->getTable(PriceHistoryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PriceHistoryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PriceHistoryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PriceHistoryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PriceHistory or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PriceHistory object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \GW2Exchange\Database\PriceHistory) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PriceHistoryTableMap::DATABASE_NAME);
            $criteria->add(PriceHistoryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PriceHistoryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PriceHistoryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PriceHistoryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the price_history table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PriceHistoryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PriceHistory or Criteria object.
     *
     * @param mixed               $criteria Criteria or PriceHistory object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PriceHistory object
        }

        if ($criteria->containsKey(PriceHistoryTableMap::COL_ID) && $criteria->keyContainsValue(PriceHistoryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PriceHistoryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PriceHistoryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PriceHistoryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PriceHistoryTableMap::buildTableMap();
