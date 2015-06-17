<?php

namespace GW2Exchange\Database\Map;

use GW2Exchange\Database\ItemInfo;
use GW2Exchange\Database\ItemInfoQuery;
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
 * This class defines the structure of the 'item_info' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemInfoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'GW2Exchange.Database.Map.ItemInfoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'GW2Exchange';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item_info';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\GW2Exchange\\Database\\ItemInfo';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'GW2Exchange.Database.ItemInfo';

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
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'item_info.item_id';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'item_info.description';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'item_info.type';

    /**
     * the column name for the rarity field
     */
    const COL_RARITY = 'item_info.rarity';

    /**
     * the column name for the level field
     */
    const COL_LEVEL = 'item_info.level';

    /**
     * the column name for the vendor_value field
     */
    const COL_VENDOR_VALUE = 'item_info.vendor_value';

    /**
     * the column name for the default_skin field
     */
    const COL_DEFAULT_SKIN = 'item_info.default_skin';

    /**
     * the column name for the flags field
     */
    const COL_FLAGS = 'item_info.flags';

    /**
     * the column name for the game_types field
     */
    const COL_GAME_TYPES = 'item_info.game_types';

    /**
     * the column name for the restrictions field
     */
    const COL_RESTRICTIONS = 'item_info.restrictions';

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
        self::TYPE_PHPNAME       => array('ItemId', 'Description', 'Type', 'Rarity', 'Level', 'VendorValue', 'DefaultSkin', 'Flags', 'GameTypes', 'Restrictions', ),
        self::TYPE_CAMELNAME     => array('itemId', 'description', 'type', 'rarity', 'level', 'vendorValue', 'defaultSkin', 'flags', 'gameTypes', 'restrictions', ),
        self::TYPE_COLNAME       => array(ItemInfoTableMap::COL_ITEM_ID, ItemInfoTableMap::COL_DESCRIPTION, ItemInfoTableMap::COL_TYPE, ItemInfoTableMap::COL_RARITY, ItemInfoTableMap::COL_LEVEL, ItemInfoTableMap::COL_VENDOR_VALUE, ItemInfoTableMap::COL_DEFAULT_SKIN, ItemInfoTableMap::COL_FLAGS, ItemInfoTableMap::COL_GAME_TYPES, ItemInfoTableMap::COL_RESTRICTIONS, ),
        self::TYPE_FIELDNAME     => array('item_id', 'description', 'type', 'rarity', 'level', 'vendor_value', 'default_skin', 'flags', 'game_types', 'restrictions', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ItemId' => 0, 'Description' => 1, 'Type' => 2, 'Rarity' => 3, 'Level' => 4, 'VendorValue' => 5, 'DefaultSkin' => 6, 'Flags' => 7, 'GameTypes' => 8, 'Restrictions' => 9, ),
        self::TYPE_CAMELNAME     => array('itemId' => 0, 'description' => 1, 'type' => 2, 'rarity' => 3, 'level' => 4, 'vendorValue' => 5, 'defaultSkin' => 6, 'flags' => 7, 'gameTypes' => 8, 'restrictions' => 9, ),
        self::TYPE_COLNAME       => array(ItemInfoTableMap::COL_ITEM_ID => 0, ItemInfoTableMap::COL_DESCRIPTION => 1, ItemInfoTableMap::COL_TYPE => 2, ItemInfoTableMap::COL_RARITY => 3, ItemInfoTableMap::COL_LEVEL => 4, ItemInfoTableMap::COL_VENDOR_VALUE => 5, ItemInfoTableMap::COL_DEFAULT_SKIN => 6, ItemInfoTableMap::COL_FLAGS => 7, ItemInfoTableMap::COL_GAME_TYPES => 8, ItemInfoTableMap::COL_RESTRICTIONS => 9, ),
        self::TYPE_FIELDNAME     => array('item_id' => 0, 'description' => 1, 'type' => 2, 'rarity' => 3, 'level' => 4, 'vendor_value' => 5, 'default_skin' => 6, 'flags' => 7, 'game_types' => 8, 'restrictions' => 9, ),
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
        $this->setName('item_info');
        $this->setPhpName('ItemInfo');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\GW2Exchange\\Database\\ItemInfo');
        $this->setPackage('GW2Exchange.Database');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('item_id', 'ItemId', 'INTEGER' , 'item', 'id', true, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 255, null);
        $this->addColumn('rarity', 'Rarity', 'VARCHAR', true, 255, null);
        $this->addColumn('level', 'Level', 'INTEGER', true, null, null);
        $this->addColumn('vendor_value', 'VendorValue', 'INTEGER', true, null, null);
        $this->addColumn('default_skin', 'DefaultSkin', 'INTEGER', false, null, null);
        $this->addColumn('flags', 'Flags', 'VARCHAR', true, 255, null);
        $this->addColumn('game_types', 'GameTypes', 'VARCHAR', true, 255, null);
        $this->addColumn('restrictions', 'Restrictions', 'VARCHAR', true, 255, null);
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
        return $withPrefix ? ItemInfoTableMap::CLASS_DEFAULT : ItemInfoTableMap::OM_CLASS;
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
     * @return array           (ItemInfo object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemInfoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemInfoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemInfoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemInfoTableMap::OM_CLASS;
            /** @var ItemInfo $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemInfoTableMap::addInstanceToPool($obj, $key);
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
            $key = ItemInfoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemInfoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ItemInfo $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemInfoTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ItemInfoTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_TYPE);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_RARITY);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_LEVEL);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_VENDOR_VALUE);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_DEFAULT_SKIN);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_FLAGS);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_GAME_TYPES);
            $criteria->addSelectColumn(ItemInfoTableMap::COL_RESTRICTIONS);
        } else {
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.rarity');
            $criteria->addSelectColumn($alias . '.level');
            $criteria->addSelectColumn($alias . '.vendor_value');
            $criteria->addSelectColumn($alias . '.default_skin');
            $criteria->addSelectColumn($alias . '.flags');
            $criteria->addSelectColumn($alias . '.game_types');
            $criteria->addSelectColumn($alias . '.restrictions');
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
        return Propel::getServiceContainer()->getDatabaseMap(ItemInfoTableMap::DATABASE_NAME)->getTable(ItemInfoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemInfoTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemInfoTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemInfoTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ItemInfo or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ItemInfo object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \GW2Exchange\Database\ItemInfo) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemInfoTableMap::DATABASE_NAME);
            $criteria->add(ItemInfoTableMap::COL_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = ItemInfoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemInfoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemInfoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item_info table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemInfoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ItemInfo or Criteria object.
     *
     * @param mixed               $criteria Criteria or ItemInfo object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ItemInfo object
        }


        // Set the correct dbName
        $query = ItemInfoQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemInfoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemInfoTableMap::buildTableMap();
