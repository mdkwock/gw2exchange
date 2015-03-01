<?php

namespace Base;

use \Item as ChildItem;
use \ItemInfoQuery as ChildItemInfoQuery;
use \ItemQuery as ChildItemQuery;
use \Exception;
use \PDO;
use Map\ItemInfoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'item_info' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class ItemInfo implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ItemInfoTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the item_id field.
     * @var        int
     */
    protected $item_id;

    /**
     * The value for the item_description field.
     * @var        string
     */
    protected $item_description;

    /**
     * The value for the item_type field.
     * @var        string
     */
    protected $item_type;

    /**
     * The value for the item_rarity field.
     * @var        string
     */
    protected $item_rarity;

    /**
     * The value for the item_level field.
     * @var        int
     */
    protected $item_level;

    /**
     * The value for the item_vendor_value field.
     * @var        int
     */
    protected $item_vendor_value;

    /**
     * The value for the item_default_skin field.
     * @var        int
     */
    protected $item_default_skin;

    /**
     * The value for the item_flags field.
     * @var        string
     */
    protected $item_flags;

    /**
     * The value for the item_game_types field.
     * @var        string
     */
    protected $item_game_types;

    /**
     * The value for the item_restrictions field.
     * @var        string
     */
    protected $item_restrictions;

    /**
     * @var        ChildItem
     */
    protected $aItem;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\ItemInfo object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>ItemInfo</code> instance.  If
     * <code>obj</code> is an instance of <code>ItemInfo</code>, delegates to
     * <code>equals(ItemInfo)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|ItemInfo The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [item_id] column value.
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Get the [item_description] column value.
     *
     * @return string
     */
    public function getItemDescription()
    {
        return $this->item_description;
    }

    /**
     * Get the [item_type] column value.
     *
     * @return string
     */
    public function getItemType()
    {
        return $this->item_type;
    }

    /**
     * Get the [item_rarity] column value.
     *
     * @return string
     */
    public function getItemRarity()
    {
        return $this->item_rarity;
    }

    /**
     * Get the [item_level] column value.
     *
     * @return int
     */
    public function getItemLevel()
    {
        return $this->item_level;
    }

    /**
     * Get the [item_vendor_value] column value.
     *
     * @return int
     */
    public function getItemVendorValue()
    {
        return $this->item_vendor_value;
    }

    /**
     * Get the [item_default_skin] column value.
     *
     * @return int
     */
    public function getItemDefaultSkin()
    {
        return $this->item_default_skin;
    }

    /**
     * Get the [item_flags] column value.
     *
     * @return string
     */
    public function getItemFlags()
    {
        return $this->item_flags;
    }

    /**
     * Get the [item_game_types] column value.
     *
     * @return string
     */
    public function getItemGameTypes()
    {
        return $this->item_game_types;
    }

    /**
     * Get the [item_restrictions] column value.
     *
     * @return string
     */
    public function getItemRestrictions()
    {
        return $this->item_restrictions;
    }

    /**
     * Set the value of [item_id] column.
     *
     * @param int $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_ID] = true;
        }

        if ($this->aItem !== null && $this->aItem->getId() !== $v) {
            $this->aItem = null;
        }

        return $this;
    } // setItemId()

    /**
     * Set the value of [item_description] column.
     *
     * @param string $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_description !== $v) {
            $this->item_description = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_DESCRIPTION] = true;
        }

        return $this;
    } // setItemDescription()

    /**
     * Set the value of [item_type] column.
     *
     * @param string $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_type !== $v) {
            $this->item_type = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_TYPE] = true;
        }

        return $this;
    } // setItemType()

    /**
     * Set the value of [item_rarity] column.
     *
     * @param string $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemRarity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_rarity !== $v) {
            $this->item_rarity = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_RARITY] = true;
        }

        return $this;
    } // setItemRarity()

    /**
     * Set the value of [item_level] column.
     *
     * @param int $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemLevel($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_level !== $v) {
            $this->item_level = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_LEVEL] = true;
        }

        return $this;
    } // setItemLevel()

    /**
     * Set the value of [item_vendor_value] column.
     *
     * @param int $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemVendorValue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_vendor_value !== $v) {
            $this->item_vendor_value = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_VENDOR_VALUE] = true;
        }

        return $this;
    } // setItemVendorValue()

    /**
     * Set the value of [item_default_skin] column.
     *
     * @param int $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemDefaultSkin($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_default_skin !== $v) {
            $this->item_default_skin = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN] = true;
        }

        return $this;
    } // setItemDefaultSkin()

    /**
     * Set the value of [item_flags] column.
     *
     * @param string $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemFlags($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_flags !== $v) {
            $this->item_flags = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_FLAGS] = true;
        }

        return $this;
    } // setItemFlags()

    /**
     * Set the value of [item_game_types] column.
     *
     * @param string $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemGameTypes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_game_types !== $v) {
            $this->item_game_types = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_GAME_TYPES] = true;
        }

        return $this;
    } // setItemGameTypes()

    /**
     * Set the value of [item_restrictions] column.
     *
     * @param string $v new value
     * @return $this|\ItemInfo The current object (for fluent API support)
     */
    public function setItemRestrictions($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_restrictions !== $v) {
            $this->item_restrictions = $v;
            $this->modifiedColumns[ItemInfoTableMap::COL_ITEM_RESTRICTIONS] = true;
        }

        return $this;
    } // setItemRestrictions()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemInfoTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemInfoTableMap::translateFieldName('ItemDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemInfoTableMap::translateFieldName('ItemType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemInfoTableMap::translateFieldName('ItemRarity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_rarity = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemInfoTableMap::translateFieldName('ItemLevel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_level = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemInfoTableMap::translateFieldName('ItemVendorValue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_vendor_value = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemInfoTableMap::translateFieldName('ItemDefaultSkin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_default_skin = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ItemInfoTableMap::translateFieldName('ItemFlags', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_flags = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ItemInfoTableMap::translateFieldName('ItemGameTypes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_game_types = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ItemInfoTableMap::translateFieldName('ItemRestrictions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_restrictions = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ItemInfoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ItemInfo'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aItem !== null && $this->item_id !== $this->aItem->getId()) {
            $this->aItem = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemInfoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aItem = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ItemInfo::setDeleted()
     * @see ItemInfo::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemInfoQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemInfoTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ItemInfoTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aItem !== null) {
                if ($this->aItem->isModified() || $this->aItem->isNew()) {
                    $affectedRows += $this->aItem->save($con);
                }
                $this->setItem($this->aItem);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_id';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'item_description';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'item_type';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_RARITY)) {
            $modifiedColumns[':p' . $index++]  = 'item_rarity';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_LEVEL)) {
            $modifiedColumns[':p' . $index++]  = 'item_level';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_VENDOR_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'item_vendor_value';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN)) {
            $modifiedColumns[':p' . $index++]  = 'item_default_skin';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_FLAGS)) {
            $modifiedColumns[':p' . $index++]  = 'item_flags';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_GAME_TYPES)) {
            $modifiedColumns[':p' . $index++]  = 'item_game_types';
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_RESTRICTIONS)) {
            $modifiedColumns[':p' . $index++]  = 'item_restrictions';
        }

        $sql = sprintf(
            'INSERT INTO item_info (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'item_id':
                        $stmt->bindValue($identifier, $this->item_id, PDO::PARAM_INT);
                        break;
                    case 'item_description':
                        $stmt->bindValue($identifier, $this->item_description, PDO::PARAM_STR);
                        break;
                    case 'item_type':
                        $stmt->bindValue($identifier, $this->item_type, PDO::PARAM_STR);
                        break;
                    case 'item_rarity':
                        $stmt->bindValue($identifier, $this->item_rarity, PDO::PARAM_STR);
                        break;
                    case 'item_level':
                        $stmt->bindValue($identifier, $this->item_level, PDO::PARAM_INT);
                        break;
                    case 'item_vendor_value':
                        $stmt->bindValue($identifier, $this->item_vendor_value, PDO::PARAM_INT);
                        break;
                    case 'item_default_skin':
                        $stmt->bindValue($identifier, $this->item_default_skin, PDO::PARAM_INT);
                        break;
                    case 'item_flags':
                        $stmt->bindValue($identifier, $this->item_flags, PDO::PARAM_STR);
                        break;
                    case 'item_game_types':
                        $stmt->bindValue($identifier, $this->item_game_types, PDO::PARAM_STR);
                        break;
                    case 'item_restrictions':
                        $stmt->bindValue($identifier, $this->item_restrictions, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemInfoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getItemId();
                break;
            case 1:
                return $this->getItemDescription();
                break;
            case 2:
                return $this->getItemType();
                break;
            case 3:
                return $this->getItemRarity();
                break;
            case 4:
                return $this->getItemLevel();
                break;
            case 5:
                return $this->getItemVendorValue();
                break;
            case 6:
                return $this->getItemDefaultSkin();
                break;
            case 7:
                return $this->getItemFlags();
                break;
            case 8:
                return $this->getItemGameTypes();
                break;
            case 9:
                return $this->getItemRestrictions();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['ItemInfo'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ItemInfo'][$this->hashCode()] = true;
        $keys = ItemInfoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemId(),
            $keys[1] => $this->getItemDescription(),
            $keys[2] => $this->getItemType(),
            $keys[3] => $this->getItemRarity(),
            $keys[4] => $this->getItemLevel(),
            $keys[5] => $this->getItemVendorValue(),
            $keys[6] => $this->getItemDefaultSkin(),
            $keys[7] => $this->getItemFlags(),
            $keys[8] => $this->getItemGameTypes(),
            $keys[9] => $this->getItemRestrictions(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aItem) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'item';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'item';
                        break;
                    default:
                        $key = 'Item';
                }

                $result[$key] = $this->aItem->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\ItemInfo
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemInfoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ItemInfo
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemId($value);
                break;
            case 1:
                $this->setItemDescription($value);
                break;
            case 2:
                $this->setItemType($value);
                break;
            case 3:
                $this->setItemRarity($value);
                break;
            case 4:
                $this->setItemLevel($value);
                break;
            case 5:
                $this->setItemVendorValue($value);
                break;
            case 6:
                $this->setItemDefaultSkin($value);
                break;
            case 7:
                $this->setItemFlags($value);
                break;
            case 8:
                $this->setItemGameTypes($value);
                break;
            case 9:
                $this->setItemRestrictions($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ItemInfoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setItemDescription($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setItemType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setItemRarity($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setItemLevel($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setItemVendorValue($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setItemDefaultSkin($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setItemFlags($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setItemGameTypes($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setItemRestrictions($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\ItemInfo The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ItemInfoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_ID)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_ID, $this->item_id);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_DESCRIPTION)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_DESCRIPTION, $this->item_description);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_TYPE)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_TYPE, $this->item_type);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_RARITY)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_RARITY, $this->item_rarity);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_LEVEL)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_LEVEL, $this->item_level);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_VENDOR_VALUE)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_VENDOR_VALUE, $this->item_vendor_value);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_DEFAULT_SKIN, $this->item_default_skin);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_FLAGS)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_FLAGS, $this->item_flags);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_GAME_TYPES)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_GAME_TYPES, $this->item_game_types);
        }
        if ($this->isColumnModified(ItemInfoTableMap::COL_ITEM_RESTRICTIONS)) {
            $criteria->add(ItemInfoTableMap::COL_ITEM_RESTRICTIONS, $this->item_restrictions);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildItemInfoQuery::create();
        $criteria->add(ItemInfoTableMap::COL_ITEM_ID, $this->item_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getItemId();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation item_info_fk_5cf635 to table item
        if ($this->aItem && $hash = spl_object_hash($this->aItem)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getItemId();
    }

    /**
     * Generic method to set the primary key (item_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \ItemInfo (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setItemId($this->getItemId());
        $copyObj->setItemDescription($this->getItemDescription());
        $copyObj->setItemType($this->getItemType());
        $copyObj->setItemRarity($this->getItemRarity());
        $copyObj->setItemLevel($this->getItemLevel());
        $copyObj->setItemVendorValue($this->getItemVendorValue());
        $copyObj->setItemDefaultSkin($this->getItemDefaultSkin());
        $copyObj->setItemFlags($this->getItemFlags());
        $copyObj->setItemGameTypes($this->getItemGameTypes());
        $copyObj->setItemRestrictions($this->getItemRestrictions());
        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \ItemInfo Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildItem object.
     *
     * @param  ChildItem $v
     * @return $this|\ItemInfo The current object (for fluent API support)
     * @throws PropelException
     */
    public function setItem(ChildItem $v = null)
    {
        if ($v === null) {
            $this->setItemId(NULL);
        } else {
            $this->setItemId($v->getId());
        }

        $this->aItem = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setItemInfo($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildItem object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildItem The associated ChildItem object.
     * @throws PropelException
     */
    public function getItem(ConnectionInterface $con = null)
    {
        if ($this->aItem === null && ($this->item_id !== null)) {
            $this->aItem = ChildItemQuery::create()->findPk($this->item_id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aItem->setItemInfo($this);
        }

        return $this->aItem;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aItem) {
            $this->aItem->removeItemInfo($this);
        }
        $this->item_id = null;
        $this->item_description = null;
        $this->item_type = null;
        $this->item_rarity = null;
        $this->item_level = null;
        $this->item_vendor_value = null;
        $this->item_default_skin = null;
        $this->item_flags = null;
        $this->item_game_types = null;
        $this->item_restrictions = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aItem = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemInfoTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
