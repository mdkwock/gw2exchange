<?php

namespace GW2Exchange\Database\Base;

use \DateTime;
use \Exception;
use \PDO;
use GW2Exchange\Database\Item as ChildItem;
use GW2Exchange\Database\ItemDetail as ChildItemDetail;
use GW2Exchange\Database\ItemDetailQuery as ChildItemDetailQuery;
use GW2Exchange\Database\ItemInfo as ChildItemInfo;
use GW2Exchange\Database\ItemInfoQuery as ChildItemInfoQuery;
use GW2Exchange\Database\ItemItemDetail as ChildItemItemDetail;
use GW2Exchange\Database\ItemItemDetailQuery as ChildItemItemDetailQuery;
use GW2Exchange\Database\ItemQuery as ChildItemQuery;
use GW2Exchange\Database\Listing as ChildListing;
use GW2Exchange\Database\ListingQuery as ChildListingQuery;
use GW2Exchange\Database\Price as ChildPrice;
use GW2Exchange\Database\PriceHistory as ChildPriceHistory;
use GW2Exchange\Database\PriceHistoryQuery as ChildPriceHistoryQuery;
use GW2Exchange\Database\PriceQuery as ChildPriceQuery;
use GW2Exchange\Database\Map\ItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'item' table.
 *
 *
 *
* @package    propel.generator.GW2Exchange.Database.Base
*/
abstract class Item implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\GW2Exchange\\Database\\Map\\ItemTableMap';


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
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the icon field.
     * @var        string
     */
    protected $icon;

    /**
     * The value for the hash field.
     * @var        string
     */
    protected $hash;

    /**
     * The value for the cache_time field.
     * @var        int
     */
    protected $cache_time;

    /**
     * The value for the created_at field.
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        \DateTime
     */
    protected $updated_at;

    /**
     * @var        ChildItemInfo one-to-one related ChildItemInfo object
     */
    protected $singleItemInfo;

    /**
     * @var        ObjectCollection|ChildItemItemDetail[] Collection to store aggregation of ChildItemItemDetail objects.
     */
    protected $collItemItemDetails;
    protected $collItemItemDetailsPartial;

    /**
     * @var        ObjectCollection|ChildListing[] Collection to store aggregation of ChildListing objects.
     */
    protected $collListings;
    protected $collListingsPartial;

    /**
     * @var        ChildPrice one-to-one related ChildPrice object
     */
    protected $singlePrice;

    /**
     * @var        ObjectCollection|ChildPriceHistory[] Collection to store aggregation of ChildPriceHistory objects.
     */
    protected $collPriceHistories;
    protected $collPriceHistoriesPartial;

    /**
     * @var        ObjectCollection|ChildItemDetail[] Cross Collection to store aggregation of ChildItemDetail objects.
     */
    protected $collItemDetails;

    /**
     * @var bool
     */
    protected $collItemDetailsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItemDetail[]
     */
    protected $itemDetailsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItemItemDetail[]
     */
    protected $itemItemDetailsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildListing[]
     */
    protected $listingsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPriceHistory[]
     */
    protected $priceHistoriesScheduledForDeletion = null;

    /**
     * Initializes internal state of GW2Exchange\Database\Base\Item object.
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
     * Compares this with another <code>Item</code> instance.  If
     * <code>obj</code> is an instance of <code>Item</code>, delegates to
     * <code>equals(Item)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Item The current object, for fluid interface
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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [icon] column value.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Get the [hash] column value.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get the [cache_time] column value.
     *
     * @return int
     */
    public function getCacheTime()
    {
        return $this->cache_time;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ItemTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ItemTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [icon] column.
     *
     * @param string $v new value
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[ItemTableMap::COL_ICON] = true;
        }

        return $this;
    } // setIcon()

    /**
     * Set the value of [hash] column.
     *
     * @param string $v new value
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hash !== $v) {
            $this->hash = $v;
            $this->modifiedColumns[ItemTableMap::COL_HASH] = true;
        }

        return $this;
    } // setHash()

    /**
     * Set the value of [cache_time] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setCacheTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cache_time !== $v) {
            $this->cache_time = $v;
            $this->modifiedColumns[ItemTableMap::COL_CACHE_TIME] = true;
        }

        return $this;
    } // setCacheTime()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ItemTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemTableMap::translateFieldName('Icon', TableMap::TYPE_PHPNAME, $indexType)];
            $this->icon = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemTableMap::translateFieldName('Hash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemTableMap::translateFieldName('CacheTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cache_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = ItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\GW2Exchange\\Database\\Item'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->singleItemInfo = null;

            $this->collItemItemDetails = null;

            $this->collListings = null;

            $this->singlePrice = null;

            $this->collPriceHistories = null;

            $this->collItemDetails = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Item::setDeleted()
     * @see Item::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ItemTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ItemTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ItemTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ItemTableMap::addInstanceToPool($this);
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

            if ($this->itemDetailsScheduledForDeletion !== null) {
                if (!$this->itemDetailsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->itemDetailsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \GW2Exchange\Database\ItemItemDetailQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->itemDetailsScheduledForDeletion = null;
                }

            }

            if ($this->collItemDetails) {
                foreach ($this->collItemDetails as $itemDetail) {
                    if (!$itemDetail->isDeleted() && ($itemDetail->isNew() || $itemDetail->isModified())) {
                        $itemDetail->save($con);
                    }
                }
            }


            if ($this->singleItemInfo !== null) {
                if (!$this->singleItemInfo->isDeleted() && ($this->singleItemInfo->isNew() || $this->singleItemInfo->isModified())) {
                    $affectedRows += $this->singleItemInfo->save($con);
                }
            }

            if ($this->itemItemDetailsScheduledForDeletion !== null) {
                if (!$this->itemItemDetailsScheduledForDeletion->isEmpty()) {
                    \GW2Exchange\Database\ItemItemDetailQuery::create()
                        ->filterByPrimaryKeys($this->itemItemDetailsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemItemDetailsScheduledForDeletion = null;
                }
            }

            if ($this->collItemItemDetails !== null) {
                foreach ($this->collItemItemDetails as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->listingsScheduledForDeletion !== null) {
                if (!$this->listingsScheduledForDeletion->isEmpty()) {
                    foreach ($this->listingsScheduledForDeletion as $listing) {
                        // need to save related object because we set the relation to null
                        $listing->save($con);
                    }
                    $this->listingsScheduledForDeletion = null;
                }
            }

            if ($this->collListings !== null) {
                foreach ($this->collListings as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singlePrice !== null) {
                if (!$this->singlePrice->isDeleted() && ($this->singlePrice->isNew() || $this->singlePrice->isModified())) {
                    $affectedRows += $this->singlePrice->save($con);
                }
            }

            if ($this->priceHistoriesScheduledForDeletion !== null) {
                if (!$this->priceHistoriesScheduledForDeletion->isEmpty()) {
                    foreach ($this->priceHistoriesScheduledForDeletion as $priceHistory) {
                        // need to save related object because we set the relation to null
                        $priceHistory->save($con);
                    }
                    $this->priceHistoriesScheduledForDeletion = null;
                }
            }

            if ($this->collPriceHistories !== null) {
                foreach ($this->collPriceHistories as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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
        if ($this->isColumnModified(ItemTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ItemTableMap::COL_ICON)) {
            $modifiedColumns[':p' . $index++]  = 'icon';
        }
        if ($this->isColumnModified(ItemTableMap::COL_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'hash';
        }
        if ($this->isColumnModified(ItemTableMap::COL_CACHE_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'cache_time';
        }
        if ($this->isColumnModified(ItemTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(ItemTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'icon':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
                        break;
                    case 'hash':
                        $stmt->bindValue($identifier, $this->hash, PDO::PARAM_STR);
                        break;
                    case 'cache_time':
                        $stmt->bindValue($identifier, $this->cache_time, PDO::PARAM_INT);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getIcon();
                break;
            case 3:
                return $this->getHash();
                break;
            case 4:
                return $this->getCacheTime();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
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

        if (isset($alreadyDumpedObjects['Item'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Item'][$this->hashCode()] = true;
        $keys = ItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getIcon(),
            $keys[3] => $this->getHash(),
            $keys[4] => $this->getCacheTime(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[5]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[5]];
            $result[$keys[5]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->singleItemInfo) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemInfo';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'item_info';
                        break;
                    default:
                        $key = 'ItemInfo';
                }

                $result[$key] = $this->singleItemInfo->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collItemItemDetails) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemItemDetails';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'item_item_details';
                        break;
                    default:
                        $key = 'ItemItemDetails';
                }

                $result[$key] = $this->collItemItemDetails->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collListings) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'listings';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'listings';
                        break;
                    default:
                        $key = 'Listings';
                }

                $result[$key] = $this->collListings->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singlePrice) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'price';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'price';
                        break;
                    default:
                        $key = 'Price';
                }

                $result[$key] = $this->singlePrice->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPriceHistories) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'priceHistories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'price_histories';
                        break;
                    default:
                        $key = 'PriceHistories';
                }

                $result[$key] = $this->collPriceHistories->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\GW2Exchange\Database\Item
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\GW2Exchange\Database\Item
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setIcon($value);
                break;
            case 3:
                $this->setHash($value);
                break;
            case 4:
                $this->setCacheTime($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
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
        $keys = ItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIcon($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHash($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCacheTime($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
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
     * @return $this|\GW2Exchange\Database\Item The current object, for fluid interface
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
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemTableMap::COL_ID)) {
            $criteria->add(ItemTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_NAME)) {
            $criteria->add(ItemTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ItemTableMap::COL_ICON)) {
            $criteria->add(ItemTableMap::COL_ICON, $this->icon);
        }
        if ($this->isColumnModified(ItemTableMap::COL_HASH)) {
            $criteria->add(ItemTableMap::COL_HASH, $this->hash);
        }
        if ($this->isColumnModified(ItemTableMap::COL_CACHE_TIME)) {
            $criteria->add(ItemTableMap::COL_CACHE_TIME, $this->cache_time);
        }
        if ($this->isColumnModified(ItemTableMap::COL_CREATED_AT)) {
            $criteria->add(ItemTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ItemTableMap::COL_UPDATED_AT)) {
            $criteria->add(ItemTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildItemQuery::create();
        $criteria->add(ItemTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

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
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \GW2Exchange\Database\Item (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setName($this->getName());
        $copyObj->setIcon($this->getIcon());
        $copyObj->setHash($this->getHash());
        $copyObj->setCacheTime($this->getCacheTime());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getItemInfo();
            if ($relObj) {
                $copyObj->setItemInfo($relObj->copy($deepCopy));
            }

            foreach ($this->getItemItemDetails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItemItemDetail($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getListings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addListing($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getPrice();
            if ($relObj) {
                $copyObj->setPrice($relObj->copy($deepCopy));
            }

            foreach ($this->getPriceHistories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPriceHistory($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

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
     * @return \GW2Exchange\Database\Item Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ItemItemDetail' == $relationName) {
            return $this->initItemItemDetails();
        }
        if ('Listing' == $relationName) {
            return $this->initListings();
        }
        if ('PriceHistory' == $relationName) {
            return $this->initPriceHistories();
        }
    }

    /**
     * Gets a single ChildItemInfo object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildItemInfo
     * @throws PropelException
     */
    public function getItemInfo(ConnectionInterface $con = null)
    {

        if ($this->singleItemInfo === null && !$this->isNew()) {
            $this->singleItemInfo = ChildItemInfoQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleItemInfo;
    }

    /**
     * Sets a single ChildItemInfo object as related to this object by a one-to-one relationship.
     *
     * @param  ChildItemInfo $v ChildItemInfo
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setItemInfo(ChildItemInfo $v = null)
    {
        $this->singleItemInfo = $v;

        // Make sure that that the passed-in ChildItemInfo isn't already associated with this object
        if ($v !== null && $v->getItem(null, false) === null) {
            $v->setItem($this);
        }

        return $this;
    }

    /**
     * Clears out the collItemItemDetails collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItemItemDetails()
     */
    public function clearItemItemDetails()
    {
        $this->collItemItemDetails = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItemItemDetails collection loaded partially.
     */
    public function resetPartialItemItemDetails($v = true)
    {
        $this->collItemItemDetailsPartial = $v;
    }

    /**
     * Initializes the collItemItemDetails collection.
     *
     * By default this just sets the collItemItemDetails collection to an empty array (like clearcollItemItemDetails());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItemItemDetails($overrideExisting = true)
    {
        if (null !== $this->collItemItemDetails && !$overrideExisting) {
            return;
        }
        $this->collItemItemDetails = new ObjectCollection();
        $this->collItemItemDetails->setModel('\GW2Exchange\Database\ItemItemDetail');
    }

    /**
     * Gets an array of ChildItemItemDetail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItemItemDetail[] List of ChildItemItemDetail objects
     * @throws PropelException
     */
    public function getItemItemDetails(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemItemDetailsPartial && !$this->isNew();
        if (null === $this->collItemItemDetails || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItemItemDetails) {
                // return empty collection
                $this->initItemItemDetails();
            } else {
                $collItemItemDetails = ChildItemItemDetailQuery::create(null, $criteria)
                    ->filterByItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemItemDetailsPartial && count($collItemItemDetails)) {
                        $this->initItemItemDetails(false);

                        foreach ($collItemItemDetails as $obj) {
                            if (false == $this->collItemItemDetails->contains($obj)) {
                                $this->collItemItemDetails->append($obj);
                            }
                        }

                        $this->collItemItemDetailsPartial = true;
                    }

                    return $collItemItemDetails;
                }

                if ($partial && $this->collItemItemDetails) {
                    foreach ($this->collItemItemDetails as $obj) {
                        if ($obj->isNew()) {
                            $collItemItemDetails[] = $obj;
                        }
                    }
                }

                $this->collItemItemDetails = $collItemItemDetails;
                $this->collItemItemDetailsPartial = false;
            }
        }

        return $this->collItemItemDetails;
    }

    /**
     * Sets a collection of ChildItemItemDetail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $itemItemDetails A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setItemItemDetails(Collection $itemItemDetails, ConnectionInterface $con = null)
    {
        /** @var ChildItemItemDetail[] $itemItemDetailsToDelete */
        $itemItemDetailsToDelete = $this->getItemItemDetails(new Criteria(), $con)->diff($itemItemDetails);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->itemItemDetailsScheduledForDeletion = clone $itemItemDetailsToDelete;

        foreach ($itemItemDetailsToDelete as $itemItemDetailRemoved) {
            $itemItemDetailRemoved->setItem(null);
        }

        $this->collItemItemDetails = null;
        foreach ($itemItemDetails as $itemItemDetail) {
            $this->addItemItemDetail($itemItemDetail);
        }

        $this->collItemItemDetails = $itemItemDetails;
        $this->collItemItemDetailsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ItemItemDetail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ItemItemDetail objects.
     * @throws PropelException
     */
    public function countItemItemDetails(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemItemDetailsPartial && !$this->isNew();
        if (null === $this->collItemItemDetails || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItemItemDetails) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItemItemDetails());
            }

            $query = ChildItemItemDetailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collItemItemDetails);
    }

    /**
     * Method called to associate a ChildItemItemDetail object to this object
     * through the ChildItemItemDetail foreign key attribute.
     *
     * @param  ChildItemItemDetail $l ChildItemItemDetail
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function addItemItemDetail(ChildItemItemDetail $l)
    {
        if ($this->collItemItemDetails === null) {
            $this->initItemItemDetails();
            $this->collItemItemDetailsPartial = true;
        }

        if (!$this->collItemItemDetails->contains($l)) {
            $this->doAddItemItemDetail($l);
        }

        return $this;
    }

    /**
     * @param ChildItemItemDetail $itemItemDetail The ChildItemItemDetail object to add.
     */
    protected function doAddItemItemDetail(ChildItemItemDetail $itemItemDetail)
    {
        $this->collItemItemDetails[]= $itemItemDetail;
        $itemItemDetail->setItem($this);
    }

    /**
     * @param  ChildItemItemDetail $itemItemDetail The ChildItemItemDetail object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removeItemItemDetail(ChildItemItemDetail $itemItemDetail)
    {
        if ($this->getItemItemDetails()->contains($itemItemDetail)) {
            $pos = $this->collItemItemDetails->search($itemItemDetail);
            $this->collItemItemDetails->remove($pos);
            if (null === $this->itemItemDetailsScheduledForDeletion) {
                $this->itemItemDetailsScheduledForDeletion = clone $this->collItemItemDetails;
                $this->itemItemDetailsScheduledForDeletion->clear();
            }
            $this->itemItemDetailsScheduledForDeletion[]= clone $itemItemDetail;
            $itemItemDetail->setItem(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Item is new, it will return
     * an empty collection; or if this Item has previously
     * been saved, it will retrieve related ItemItemDetails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Item.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItemItemDetail[] List of ChildItemItemDetail objects
     */
    public function getItemItemDetailsJoinItemDetail(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemItemDetailQuery::create(null, $criteria);
        $query->joinWith('ItemDetail', $joinBehavior);

        return $this->getItemItemDetails($query, $con);
    }

    /**
     * Clears out the collListings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addListings()
     */
    public function clearListings()
    {
        $this->collListings = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collListings collection loaded partially.
     */
    public function resetPartialListings($v = true)
    {
        $this->collListingsPartial = $v;
    }

    /**
     * Initializes the collListings collection.
     *
     * By default this just sets the collListings collection to an empty array (like clearcollListings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initListings($overrideExisting = true)
    {
        if (null !== $this->collListings && !$overrideExisting) {
            return;
        }
        $this->collListings = new ObjectCollection();
        $this->collListings->setModel('\GW2Exchange\Database\Listing');
    }

    /**
     * Gets an array of ChildListing objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildListing[] List of ChildListing objects
     * @throws PropelException
     */
    public function getListings(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collListingsPartial && !$this->isNew();
        if (null === $this->collListings || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collListings) {
                // return empty collection
                $this->initListings();
            } else {
                $collListings = ChildListingQuery::create(null, $criteria)
                    ->filterByItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collListingsPartial && count($collListings)) {
                        $this->initListings(false);

                        foreach ($collListings as $obj) {
                            if (false == $this->collListings->contains($obj)) {
                                $this->collListings->append($obj);
                            }
                        }

                        $this->collListingsPartial = true;
                    }

                    return $collListings;
                }

                if ($partial && $this->collListings) {
                    foreach ($this->collListings as $obj) {
                        if ($obj->isNew()) {
                            $collListings[] = $obj;
                        }
                    }
                }

                $this->collListings = $collListings;
                $this->collListingsPartial = false;
            }
        }

        return $this->collListings;
    }

    /**
     * Sets a collection of ChildListing objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $listings A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setListings(Collection $listings, ConnectionInterface $con = null)
    {
        /** @var ChildListing[] $listingsToDelete */
        $listingsToDelete = $this->getListings(new Criteria(), $con)->diff($listings);


        $this->listingsScheduledForDeletion = $listingsToDelete;

        foreach ($listingsToDelete as $listingRemoved) {
            $listingRemoved->setItem(null);
        }

        $this->collListings = null;
        foreach ($listings as $listing) {
            $this->addListing($listing);
        }

        $this->collListings = $listings;
        $this->collListingsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Listing objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Listing objects.
     * @throws PropelException
     */
    public function countListings(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collListingsPartial && !$this->isNew();
        if (null === $this->collListings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collListings) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getListings());
            }

            $query = ChildListingQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collListings);
    }

    /**
     * Method called to associate a ChildListing object to this object
     * through the ChildListing foreign key attribute.
     *
     * @param  ChildListing $l ChildListing
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function addListing(ChildListing $l)
    {
        if ($this->collListings === null) {
            $this->initListings();
            $this->collListingsPartial = true;
        }

        if (!$this->collListings->contains($l)) {
            $this->doAddListing($l);
        }

        return $this;
    }

    /**
     * @param ChildListing $listing The ChildListing object to add.
     */
    protected function doAddListing(ChildListing $listing)
    {
        $this->collListings[]= $listing;
        $listing->setItem($this);
    }

    /**
     * @param  ChildListing $listing The ChildListing object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removeListing(ChildListing $listing)
    {
        if ($this->getListings()->contains($listing)) {
            $pos = $this->collListings->search($listing);
            $this->collListings->remove($pos);
            if (null === $this->listingsScheduledForDeletion) {
                $this->listingsScheduledForDeletion = clone $this->collListings;
                $this->listingsScheduledForDeletion->clear();
            }
            $this->listingsScheduledForDeletion[]= $listing;
            $listing->setItem(null);
        }

        return $this;
    }

    /**
     * Gets a single ChildPrice object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildPrice
     * @throws PropelException
     */
    public function getPrice(ConnectionInterface $con = null)
    {

        if ($this->singlePrice === null && !$this->isNew()) {
            $this->singlePrice = ChildPriceQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singlePrice;
    }

    /**
     * Sets a single ChildPrice object as related to this object by a one-to-one relationship.
     *
     * @param  ChildPrice $v ChildPrice
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPrice(ChildPrice $v = null)
    {
        $this->singlePrice = $v;

        // Make sure that that the passed-in ChildPrice isn't already associated with this object
        if ($v !== null && $v->getItem(null, false) === null) {
            $v->setItem($this);
        }

        return $this;
    }

    /**
     * Clears out the collPriceHistories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPriceHistories()
     */
    public function clearPriceHistories()
    {
        $this->collPriceHistories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPriceHistories collection loaded partially.
     */
    public function resetPartialPriceHistories($v = true)
    {
        $this->collPriceHistoriesPartial = $v;
    }

    /**
     * Initializes the collPriceHistories collection.
     *
     * By default this just sets the collPriceHistories collection to an empty array (like clearcollPriceHistories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPriceHistories($overrideExisting = true)
    {
        if (null !== $this->collPriceHistories && !$overrideExisting) {
            return;
        }
        $this->collPriceHistories = new ObjectCollection();
        $this->collPriceHistories->setModel('\GW2Exchange\Database\PriceHistory');
    }

    /**
     * Gets an array of ChildPriceHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPriceHistory[] List of ChildPriceHistory objects
     * @throws PropelException
     */
    public function getPriceHistories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPriceHistoriesPartial && !$this->isNew();
        if (null === $this->collPriceHistories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPriceHistories) {
                // return empty collection
                $this->initPriceHistories();
            } else {
                $collPriceHistories = ChildPriceHistoryQuery::create(null, $criteria)
                    ->filterByItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPriceHistoriesPartial && count($collPriceHistories)) {
                        $this->initPriceHistories(false);

                        foreach ($collPriceHistories as $obj) {
                            if (false == $this->collPriceHistories->contains($obj)) {
                                $this->collPriceHistories->append($obj);
                            }
                        }

                        $this->collPriceHistoriesPartial = true;
                    }

                    return $collPriceHistories;
                }

                if ($partial && $this->collPriceHistories) {
                    foreach ($this->collPriceHistories as $obj) {
                        if ($obj->isNew()) {
                            $collPriceHistories[] = $obj;
                        }
                    }
                }

                $this->collPriceHistories = $collPriceHistories;
                $this->collPriceHistoriesPartial = false;
            }
        }

        return $this->collPriceHistories;
    }

    /**
     * Sets a collection of ChildPriceHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $priceHistories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setPriceHistories(Collection $priceHistories, ConnectionInterface $con = null)
    {
        /** @var ChildPriceHistory[] $priceHistoriesToDelete */
        $priceHistoriesToDelete = $this->getPriceHistories(new Criteria(), $con)->diff($priceHistories);


        $this->priceHistoriesScheduledForDeletion = $priceHistoriesToDelete;

        foreach ($priceHistoriesToDelete as $priceHistoryRemoved) {
            $priceHistoryRemoved->setItem(null);
        }

        $this->collPriceHistories = null;
        foreach ($priceHistories as $priceHistory) {
            $this->addPriceHistory($priceHistory);
        }

        $this->collPriceHistories = $priceHistories;
        $this->collPriceHistoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PriceHistory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PriceHistory objects.
     * @throws PropelException
     */
    public function countPriceHistories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPriceHistoriesPartial && !$this->isNew();
        if (null === $this->collPriceHistories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPriceHistories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPriceHistories());
            }

            $query = ChildPriceHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collPriceHistories);
    }

    /**
     * Method called to associate a ChildPriceHistory object to this object
     * through the ChildPriceHistory foreign key attribute.
     *
     * @param  ChildPriceHistory $l ChildPriceHistory
     * @return $this|\GW2Exchange\Database\Item The current object (for fluent API support)
     */
    public function addPriceHistory(ChildPriceHistory $l)
    {
        if ($this->collPriceHistories === null) {
            $this->initPriceHistories();
            $this->collPriceHistoriesPartial = true;
        }

        if (!$this->collPriceHistories->contains($l)) {
            $this->doAddPriceHistory($l);
        }

        return $this;
    }

    /**
     * @param ChildPriceHistory $priceHistory The ChildPriceHistory object to add.
     */
    protected function doAddPriceHistory(ChildPriceHistory $priceHistory)
    {
        $this->collPriceHistories[]= $priceHistory;
        $priceHistory->setItem($this);
    }

    /**
     * @param  ChildPriceHistory $priceHistory The ChildPriceHistory object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removePriceHistory(ChildPriceHistory $priceHistory)
    {
        if ($this->getPriceHistories()->contains($priceHistory)) {
            $pos = $this->collPriceHistories->search($priceHistory);
            $this->collPriceHistories->remove($pos);
            if (null === $this->priceHistoriesScheduledForDeletion) {
                $this->priceHistoriesScheduledForDeletion = clone $this->collPriceHistories;
                $this->priceHistoriesScheduledForDeletion->clear();
            }
            $this->priceHistoriesScheduledForDeletion[]= $priceHistory;
            $priceHistory->setItem(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Item is new, it will return
     * an empty collection; or if this Item has previously
     * been saved, it will retrieve related PriceHistories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Item.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPriceHistory[] List of ChildPriceHistory objects
     */
    public function getPriceHistoriesJoinPrice(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPriceHistoryQuery::create(null, $criteria);
        $query->joinWith('Price', $joinBehavior);

        return $this->getPriceHistories($query, $con);
    }

    /**
     * Clears out the collItemDetails collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItemDetails()
     */
    public function clearItemDetails()
    {
        $this->collItemDetails = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collItemDetails crossRef collection.
     *
     * By default this just sets the collItemDetails collection to an empty collection (like clearItemDetails());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initItemDetails()
    {
        $this->collItemDetails = new ObjectCollection();
        $this->collItemDetailsPartial = true;

        $this->collItemDetails->setModel('\GW2Exchange\Database\ItemDetail');
    }

    /**
     * Checks if the collItemDetails collection is loaded.
     *
     * @return bool
     */
    public function isItemDetailsLoaded()
    {
        return null !== $this->collItemDetails;
    }

    /**
     * Gets a collection of ChildItemDetail objects related by a many-to-many relationship
     * to the current object by way of the item_item_detail cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildItemDetail[] List of ChildItemDetail objects
     */
    public function getItemDetails(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemDetailsPartial && !$this->isNew();
        if (null === $this->collItemDetails || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collItemDetails) {
                    $this->initItemDetails();
                }
            } else {

                $query = ChildItemDetailQuery::create(null, $criteria)
                    ->filterByItem($this);
                $collItemDetails = $query->find($con);
                if (null !== $criteria) {
                    return $collItemDetails;
                }

                if ($partial && $this->collItemDetails) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collItemDetails as $obj) {
                        if (!$collItemDetails->contains($obj)) {
                            $collItemDetails[] = $obj;
                        }
                    }
                }

                $this->collItemDetails = $collItemDetails;
                $this->collItemDetailsPartial = false;
            }
        }

        return $this->collItemDetails;
    }

    /**
     * Sets a collection of ItemDetail objects related by a many-to-many relationship
     * to the current object by way of the item_item_detail cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $itemDetails A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setItemDetails(Collection $itemDetails, ConnectionInterface $con = null)
    {
        $this->clearItemDetails();
        $currentItemDetails = $this->getItemDetails();

        $itemDetailsScheduledForDeletion = $currentItemDetails->diff($itemDetails);

        foreach ($itemDetailsScheduledForDeletion as $toDelete) {
            $this->removeItemDetail($toDelete);
        }

        foreach ($itemDetails as $itemDetail) {
            if (!$currentItemDetails->contains($itemDetail)) {
                $this->doAddItemDetail($itemDetail);
            }
        }

        $this->collItemDetailsPartial = false;
        $this->collItemDetails = $itemDetails;

        return $this;
    }

    /**
     * Gets the number of ItemDetail objects related by a many-to-many relationship
     * to the current object by way of the item_item_detail cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ItemDetail objects
     */
    public function countItemDetails(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemDetailsPartial && !$this->isNew();
        if (null === $this->collItemDetails || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItemDetails) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getItemDetails());
                }

                $query = ChildItemDetailQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByItem($this)
                    ->count($con);
            }
        } else {
            return count($this->collItemDetails);
        }
    }

    /**
     * Associate a ChildItemDetail to this object
     * through the item_item_detail cross reference table.
     *
     * @param ChildItemDetail $itemDetail
     * @return ChildItem The current object (for fluent API support)
     */
    public function addItemDetail(ChildItemDetail $itemDetail)
    {
        if ($this->collItemDetails === null) {
            $this->initItemDetails();
        }

        if (!$this->getItemDetails()->contains($itemDetail)) {
            // only add it if the **same** object is not already associated
            $this->collItemDetails->push($itemDetail);
            $this->doAddItemDetail($itemDetail);
        }

        return $this;
    }

    /**
     *
     * @param ChildItemDetail $itemDetail
     */
    protected function doAddItemDetail(ChildItemDetail $itemDetail)
    {
        $itemItemDetail = new ChildItemItemDetail();

        $itemItemDetail->setItemDetail($itemDetail);

        $itemItemDetail->setItem($this);

        $this->addItemItemDetail($itemItemDetail);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$itemDetail->isItemsLoaded()) {
            $itemDetail->initItems();
            $itemDetail->getItems()->push($this);
        } elseif (!$itemDetail->getItems()->contains($this)) {
            $itemDetail->getItems()->push($this);
        }

    }

    /**
     * Remove itemDetail of this object
     * through the item_item_detail cross reference table.
     *
     * @param ChildItemDetail $itemDetail
     * @return ChildItem The current object (for fluent API support)
     */
    public function removeItemDetail(ChildItemDetail $itemDetail)
    {
        if ($this->getItemDetails()->contains($itemDetail)) { $itemItemDetail = new ChildItemItemDetail();

            $itemItemDetail->setItemDetail($itemDetail);
            if ($itemDetail->isItemsLoaded()) {
                //remove the back reference if available
                $itemDetail->getItems()->removeObject($this);
            }

            $itemItemDetail->setItem($this);
            $this->removeItemItemDetail(clone $itemItemDetail);
            $itemItemDetail->clear();

            $this->collItemDetails->remove($this->collItemDetails->search($itemDetail));

            if (null === $this->itemDetailsScheduledForDeletion) {
                $this->itemDetailsScheduledForDeletion = clone $this->collItemDetails;
                $this->itemDetailsScheduledForDeletion->clear();
            }

            $this->itemDetailsScheduledForDeletion->push($itemDetail);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->icon = null;
        $this->hash = null;
        $this->cache_time = null;
        $this->created_at = null;
        $this->updated_at = null;
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
            if ($this->singleItemInfo) {
                $this->singleItemInfo->clearAllReferences($deep);
            }
            if ($this->collItemItemDetails) {
                foreach ($this->collItemItemDetails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collListings) {
                foreach ($this->collListings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singlePrice) {
                $this->singlePrice->clearAllReferences($deep);
            }
            if ($this->collPriceHistories) {
                foreach ($this->collPriceHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItemDetails) {
                foreach ($this->collItemDetails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->singleItemInfo = null;
        $this->collItemItemDetails = null;
        $this->collListings = null;
        $this->singlePrice = null;
        $this->collPriceHistories = null;
        $this->collItemDetails = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildItem The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ItemTableMap::COL_UPDATED_AT] = true;

        return $this;
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
