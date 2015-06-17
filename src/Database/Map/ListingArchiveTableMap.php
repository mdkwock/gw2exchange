<?php

namespace GW2Exchange\Database\Map;

use GW2Exchange\Database\ListingArchive;
use GW2Exchange\Database\ListingArchiveQuery;
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
 * This class defines the structure of the 'listing_archive' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ListingArchiveTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'GW2Exchange.Database.Map.ListingArchiveTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gw2exchange';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'listing_archive';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\GW2Exchange\\Database\\ListingArchive';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'GW2Exchange.Database.ListingArchive';

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
    const COL_ID = 'listing_archive.id';

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'listing_archive.item_id';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'listing_archive.type';

    /**
     * the column name for the orders field
     */
    const COL_ORDERS = 'listing_archive.orders';

    /**
     * the column name for the unit_price field
     */
    const COL_UNIT_PRICE = 'listing_archive.unit_price';

    /**
     * the column name for the quantity field
     */
    const COL_QUANTITY = 'listing_archive.quantity';

    /**
     * the column name for the cache_time field
     */
    const COL_CACHE_TIME = 'listing_archive.cache_time';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'listing_archive.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'listing_archive.updated_at';

    /**
     * the column name for the archived_at field
     */
    const COL_ARCHIVED_AT = 'listing_archive.archived_at';

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
        self::TYPE_PHPNAME       => array('Id', 'ItemId', 'Type', 'Orders', 'UnitPrice', 'Quantity', 'CacheTime', 'CreatedAt', 'UpdatedAt', 'ArchivedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'itemId', 'type', 'orders', 'unitPrice', 'quantity', 'cacheTime', 'createdAt', 'updatedAt', 'archivedAt', ),
        self::TYPE_COLNAME       => array(ListingArchiveTableMap::COL_ID, ListingArchiveTableMap::COL_ITEM_ID, ListingArchiveTableMap::COL_TYPE, ListingArchiveTableMap::COL_ORDERS, ListingArchiveTableMap::COL_UNIT_PRICE, ListingArchiveTableMap::COL_QUANTITY, ListingArchiveTableMap::COL_CACHE_TIME, ListingArchiveTableMap::COL_CREATED_AT, ListingArchiveTableMap::COL_UPDATED_AT, ListingArchiveTableMap::COL_ARCHIVED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'item_id', 'type', 'orders', 'unit_price', 'quantity', 'cache_time', 'created_at', 'updated_at', 'archived_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ItemId' => 1, 'Type' => 2, 'Orders' => 3, 'UnitPrice' => 4, 'Quantity' => 5, 'CacheTime' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, 'ArchivedAt' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'itemId' => 1, 'type' => 2, 'orders' => 3, 'unitPrice' => 4, 'quantity' => 5, 'cacheTime' => 6, 'createdAt' => 7, 'updatedAt' => 8, 'archivedAt' => 9, ),
        self::TYPE_COLNAME       => array(ListingArchiveTableMap::COL_ID => 0, ListingArchiveTableMap::COL_ITEM_ID => 1, ListingArchiveTableMap::COL_TYPE => 2, ListingArchiveTableMap::COL_ORDERS => 3, ListingArchiveTableMap::COL_UNIT_PRICE => 4, ListingArchiveTableMap::COL_QUANTITY => 5, ListingArchiveTableMap::COL_CACHE_TIME => 6, ListingArchiveTableMap::COL_CREATED_AT => 7, ListingArchiveTableMap::COL_UPDATED_AT => 8, ListingArchiveTableMap::COL_ARCHIVED_AT => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'item_id' => 1, 'type' => 2, 'orders' => 3, 'unit_price' => 4, 'quantity' => 5, 'cache_time' => 6, 'created_at' => 7, 'updated_at' => 8, 'archived_at' => 9, ),
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
        $this->setName('listing_archive');
        $this->setPhpName('ListingArchive');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\GW2Exchange\\Database\\ListingArchive');
        $this->setPackage('GW2Exchange.Database');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('item_id', 'ItemId', 'INTEGER', false, null, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 255, null);
        $this->addColumn('orders', 'Orders', 'INTEGER', true, null, null);
        $this->addColumn('unit_price', 'UnitPrice', 'INTEGER', true, null, null);
        $this->addColumn('quantity', 'Quantity', 'INTEGER', true, null, null);
        $this->addColumn('cache_time', 'CacheTime', 'INTEGER', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('archived_at', 'ArchivedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

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
        return $withPrefix ? ListingArchiveTableMap::CLASS_DEFAULT : ListingArchiveTableMap::OM_CLASS;
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
     * @return array           (ListingArchive object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ListingArchiveTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ListingArchiveTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ListingArchiveTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ListingArchiveTableMap::OM_CLASS;
            /** @var ListingArchive $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ListingArchiveTableMap::addInstanceToPool($obj, $key);
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
            $key = ListingArchiveTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ListingArchiveTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ListingArchive $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ListingArchiveTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_ID);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_TYPE);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_ORDERS);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_UNIT_PRICE);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_QUANTITY);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_CACHE_TIME);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(ListingArchiveTableMap::COL_ARCHIVED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.orders');
            $criteria->addSelectColumn($alias . '.unit_price');
            $criteria->addSelectColumn($alias . '.quantity');
            $criteria->addSelectColumn($alias . '.cache_time');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.archived_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(ListingArchiveTableMap::DATABASE_NAME)->getTable(ListingArchiveTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ListingArchiveTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ListingArchiveTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ListingArchiveTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ListingArchive or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ListingArchive object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ListingArchiveTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \GW2Exchange\Database\ListingArchive) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ListingArchiveTableMap::DATABASE_NAME);
            $criteria->add(ListingArchiveTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ListingArchiveQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ListingArchiveTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ListingArchiveTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the listing_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ListingArchiveQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ListingArchive or Criteria object.
     *
     * @param mixed               $criteria Criteria or ListingArchive object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListingArchiveTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ListingArchive object
        }


        // Set the correct dbName
        $query = ListingArchiveQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ListingArchiveTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ListingArchiveTableMap::buildTableMap();
