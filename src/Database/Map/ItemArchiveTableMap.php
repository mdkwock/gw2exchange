<?php

namespace GW2Exchange\Database\Map;

use GW2Exchange\Database\ItemArchive;
use GW2Exchange\Database\ItemArchiveQuery;
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
 * This class defines the structure of the 'item_archive' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemArchiveTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'GW2Exchange.Database.Map.ItemArchiveTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'GW2Exchange';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item_archive';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\GW2Exchange\\Database\\ItemArchive';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'GW2Exchange.Database.ItemArchive';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'item_archive.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'item_archive.name';

    /**
     * the column name for the icon field
     */
    const COL_ICON = 'item_archive.icon';

    /**
     * the column name for the cache_time field
     */
    const COL_CACHE_TIME = 'item_archive.cache_time';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'item_archive.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'item_archive.updated_at';

    /**
     * the column name for the archived_at field
     */
    const COL_ARCHIVED_AT = 'item_archive.archived_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Icon', 'CacheTime', 'CreatedAt', 'UpdatedAt', 'ArchivedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'icon', 'cacheTime', 'createdAt', 'updatedAt', 'archivedAt', ),
        self::TYPE_COLNAME       => array(ItemArchiveTableMap::COL_ID, ItemArchiveTableMap::COL_NAME, ItemArchiveTableMap::COL_ICON, ItemArchiveTableMap::COL_CACHE_TIME, ItemArchiveTableMap::COL_CREATED_AT, ItemArchiveTableMap::COL_UPDATED_AT, ItemArchiveTableMap::COL_ARCHIVED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'icon', 'cache_time', 'created_at', 'updated_at', 'archived_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Icon' => 2, 'CacheTime' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, 'ArchivedAt' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'icon' => 2, 'cacheTime' => 3, 'createdAt' => 4, 'updatedAt' => 5, 'archivedAt' => 6, ),
        self::TYPE_COLNAME       => array(ItemArchiveTableMap::COL_ID => 0, ItemArchiveTableMap::COL_NAME => 1, ItemArchiveTableMap::COL_ICON => 2, ItemArchiveTableMap::COL_CACHE_TIME => 3, ItemArchiveTableMap::COL_CREATED_AT => 4, ItemArchiveTableMap::COL_UPDATED_AT => 5, ItemArchiveTableMap::COL_ARCHIVED_AT => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'icon' => 2, 'cache_time' => 3, 'created_at' => 4, 'updated_at' => 5, 'archived_at' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('item_archive');
        $this->setPhpName('ItemArchive');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\GW2Exchange\\Database\\ItemArchive');
        $this->setPackage('GW2Exchange.Database');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('icon', 'Icon', 'VARCHAR', true, 255, null);
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
        return $withPrefix ? ItemArchiveTableMap::CLASS_DEFAULT : ItemArchiveTableMap::OM_CLASS;
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
     * @return array           (ItemArchive object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemArchiveTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemArchiveTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemArchiveTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemArchiveTableMap::OM_CLASS;
            /** @var ItemArchive $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemArchiveTableMap::addInstanceToPool($obj, $key);
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
            $key = ItemArchiveTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemArchiveTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ItemArchive $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemArchiveTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_ID);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_NAME);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_ICON);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_CACHE_TIME);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_ARCHIVED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.icon');
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
        return Propel::getServiceContainer()->getDatabaseMap(ItemArchiveTableMap::DATABASE_NAME)->getTable(ItemArchiveTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemArchiveTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemArchiveTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemArchiveTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ItemArchive or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ItemArchive object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \GW2Exchange\Database\ItemArchive) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemArchiveTableMap::DATABASE_NAME);
            $criteria->add(ItemArchiveTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ItemArchiveQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemArchiveTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemArchiveTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemArchiveQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ItemArchive or Criteria object.
     *
     * @param mixed               $criteria Criteria or ItemArchive object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ItemArchive object
        }


        // Set the correct dbName
        $query = ItemArchiveQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemArchiveTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemArchiveTableMap::buildTableMap();
