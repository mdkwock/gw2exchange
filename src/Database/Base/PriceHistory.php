<?php

namespace GW2Exchange\Database\Base;

use \DateTime;
use \Exception;
use \PDO;
use GW2Exchange\Database\Item as ChildItem;
use GW2Exchange\Database\ItemQuery as ChildItemQuery;
use GW2Exchange\Database\Price as ChildPrice;
use GW2Exchange\Database\PriceHistory as ChildPriceHistory;
use GW2Exchange\Database\PriceHistoryQuery as ChildPriceHistoryQuery;
use GW2Exchange\Database\PriceQuery as ChildPriceQuery;
use GW2Exchange\Database\RequestsLog as ChildRequestsLog;
use GW2Exchange\Database\RequestsLogQuery as ChildRequestsLogQuery;
use GW2Exchange\Database\Map\PriceHistoryTableMap;
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
 * Base class that represents a row from the 'price_history' table.
 *
 *
 *
* @package    propel.generator.GW2Exchange.Database.Base
*/
abstract class PriceHistory implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\GW2Exchange\\Database\\Map\\PriceHistoryTableMap';


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
     * The value for the item_id field.
     * @var        int
     */
    protected $item_id;

    /**
     * The value for the buy_price field.
     * @var        int
     */
    protected $buy_price;

    /**
     * The value for the sell_price field.
     * @var        int
     */
    protected $sell_price;

    /**
     * The value for the buy_qty field.
     * @var        int
     */
    protected $buy_qty;

    /**
     * The value for the sell_qty field.
     * @var        int
     */
    protected $sell_qty;

    /**
     * The value for the hash field.
     * @var        string
     */
    protected $hash;

    /**
     * The value for the profit field.
     * @var        int
     */
    protected $profit;

    /**
     * The value for the roi field.
     * @var        double
     */
    protected $roi;

    /**
     * The value for the created_at field.
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * @var        ChildItem
     */
    protected $aItem;

    /**
     * @var        ChildPrice
     */
    protected $aPrice;

    /**
     * @var        ObjectCollection|ChildRequestsLog[] Collection to store aggregation of ChildRequestsLog objects.
     */
    protected $collRequestsLogs;
    protected $collRequestsLogsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRequestsLog[]
     */
    protected $requestsLogsScheduledForDeletion = null;

    /**
     * Initializes internal state of GW2Exchange\Database\Base\PriceHistory object.
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
     * Compares this with another <code>PriceHistory</code> instance.  If
     * <code>obj</code> is an instance of <code>PriceHistory</code>, delegates to
     * <code>equals(PriceHistory)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|PriceHistory The current object, for fluid interface
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
     * Get the [item_id] column value.
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Get the [buy_price] column value.
     *
     * @return int
     */
    public function getBuyPrice()
    {
        return $this->buy_price;
    }

    /**
     * Get the [sell_price] column value.
     *
     * @return int
     */
    public function getSellPrice()
    {
        return $this->sell_price;
    }

    /**
     * Get the [buy_qty] column value.
     *
     * @return int
     */
    public function getBuyQty()
    {
        return $this->buy_qty;
    }

    /**
     * Get the [sell_qty] column value.
     *
     * @return int
     */
    public function getSellQty()
    {
        return $this->sell_qty;
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
     * Get the [profit] column value.
     *
     * @return int
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * Get the [roi] column value.
     *
     * @return double
     */
    public function getRoi()
    {
        return $this->roi;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [item_id] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_ITEM_ID] = true;
        }

        if ($this->aItem !== null && $this->aItem->getId() !== $v) {
            $this->aItem = null;
        }

        if ($this->aPrice !== null && $this->aPrice->getItemId() !== $v) {
            $this->aPrice = null;
        }

        return $this;
    } // setItemId()

    /**
     * Set the value of [buy_price] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setBuyPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy_price !== $v) {
            $this->buy_price = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_BUY_PRICE] = true;
        }

        return $this;
    } // setBuyPrice()

    /**
     * Set the value of [sell_price] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setSellPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_price !== $v) {
            $this->sell_price = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_SELL_PRICE] = true;
        }

        return $this;
    } // setSellPrice()

    /**
     * Set the value of [buy_qty] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setBuyQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy_qty !== $v) {
            $this->buy_qty = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_BUY_QTY] = true;
        }

        return $this;
    } // setBuyQty()

    /**
     * Set the value of [sell_qty] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setSellQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_qty !== $v) {
            $this->sell_qty = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_SELL_QTY] = true;
        }

        return $this;
    } // setSellQty()

    /**
     * Set the value of [hash] column.
     *
     * @param string $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hash !== $v) {
            $this->hash = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_HASH] = true;
        }

        return $this;
    } // setHash()

    /**
     * Set the value of [profit] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setProfit($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->profit !== $v) {
            $this->profit = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_PROFIT] = true;
        }

        return $this;
    } // setProfit()

    /**
     * Set the value of [roi] column.
     *
     * @param double $v new value
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setRoi($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->roi !== $v) {
            $this->roi = $v;
            $this->modifiedColumns[PriceHistoryTableMap::COL_ROI] = true;
        }

        return $this;
    } // setRoi()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PriceHistoryTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PriceHistoryTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PriceHistoryTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PriceHistoryTableMap::translateFieldName('BuyPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PriceHistoryTableMap::translateFieldName('SellPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PriceHistoryTableMap::translateFieldName('BuyQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PriceHistoryTableMap::translateFieldName('SellQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PriceHistoryTableMap::translateFieldName('Hash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PriceHistoryTableMap::translateFieldName('Profit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->profit = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PriceHistoryTableMap::translateFieldName('Roi', TableMap::TYPE_PHPNAME, $indexType)];
            $this->roi = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PriceHistoryTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = PriceHistoryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\GW2Exchange\\Database\\PriceHistory'), 0, $e);
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
        if ($this->aPrice !== null && $this->item_id !== $this->aPrice->getItemId()) {
            $this->aPrice = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPriceHistoryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aItem = null;
            $this->aPrice = null;
            $this->collRequestsLogs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PriceHistory::setDeleted()
     * @see PriceHistory::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPriceHistoryQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceHistoryTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(PriceHistoryTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
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
                PriceHistoryTableMap::addInstanceToPool($this);
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

            if ($this->aPrice !== null) {
                if ($this->aPrice->isModified() || $this->aPrice->isNew()) {
                    $affectedRows += $this->aPrice->save($con);
                }
                $this->setPrice($this->aPrice);
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

            if ($this->requestsLogsScheduledForDeletion !== null) {
                if (!$this->requestsLogsScheduledForDeletion->isEmpty()) {
                    \GW2Exchange\Database\RequestsLogQuery::create()
                        ->filterByPrimaryKeys($this->requestsLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->requestsLogsScheduledForDeletion = null;
                }
            }

            if ($this->collRequestsLogs !== null) {
                foreach ($this->collRequestsLogs as $referrerFK) {
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

        $this->modifiedColumns[PriceHistoryTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PriceHistoryTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PriceHistoryTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_id';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_BUY_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'buy_price';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_SELL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'sell_price';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_BUY_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'buy_qty';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_SELL_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'sell_qty';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'hash';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_PROFIT)) {
            $modifiedColumns[':p' . $index++]  = 'profit';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_ROI)) {
            $modifiedColumns[':p' . $index++]  = 'roi';
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }

        $sql = sprintf(
            'INSERT INTO price_history (%s) VALUES (%s)',
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
                    case 'item_id':
                        $stmt->bindValue($identifier, $this->item_id, PDO::PARAM_INT);
                        break;
                    case 'buy_price':
                        $stmt->bindValue($identifier, $this->buy_price, PDO::PARAM_INT);
                        break;
                    case 'sell_price':
                        $stmt->bindValue($identifier, $this->sell_price, PDO::PARAM_INT);
                        break;
                    case 'buy_qty':
                        $stmt->bindValue($identifier, $this->buy_qty, PDO::PARAM_INT);
                        break;
                    case 'sell_qty':
                        $stmt->bindValue($identifier, $this->sell_qty, PDO::PARAM_INT);
                        break;
                    case 'hash':
                        $stmt->bindValue($identifier, $this->hash, PDO::PARAM_STR);
                        break;
                    case 'profit':
                        $stmt->bindValue($identifier, $this->profit, PDO::PARAM_INT);
                        break;
                    case 'roi':
                        $stmt->bindValue($identifier, $this->roi, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

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
        $pos = PriceHistoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemId();
                break;
            case 2:
                return $this->getBuyPrice();
                break;
            case 3:
                return $this->getSellPrice();
                break;
            case 4:
                return $this->getBuyQty();
                break;
            case 5:
                return $this->getSellQty();
                break;
            case 6:
                return $this->getHash();
                break;
            case 7:
                return $this->getProfit();
                break;
            case 8:
                return $this->getRoi();
                break;
            case 9:
                return $this->getCreatedAt();
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

        if (isset($alreadyDumpedObjects['PriceHistory'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PriceHistory'][$this->hashCode()] = true;
        $keys = PriceHistoryTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getItemId(),
            $keys[2] => $this->getBuyPrice(),
            $keys[3] => $this->getSellPrice(),
            $keys[4] => $this->getBuyQty(),
            $keys[5] => $this->getSellQty(),
            $keys[6] => $this->getHash(),
            $keys[7] => $this->getProfit(),
            $keys[8] => $this->getRoi(),
            $keys[9] => $this->getCreatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[9]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[9]];
            $result[$keys[9]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

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
            if (null !== $this->aPrice) {

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

                $result[$key] = $this->aPrice->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRequestsLogs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'requestsLogs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'requests_logs';
                        break;
                    default:
                        $key = 'RequestsLogs';
                }

                $result[$key] = $this->collRequestsLogs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\GW2Exchange\Database\PriceHistory
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PriceHistoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\GW2Exchange\Database\PriceHistory
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setItemId($value);
                break;
            case 2:
                $this->setBuyPrice($value);
                break;
            case 3:
                $this->setSellPrice($value);
                break;
            case 4:
                $this->setBuyQty($value);
                break;
            case 5:
                $this->setSellQty($value);
                break;
            case 6:
                $this->setHash($value);
                break;
            case 7:
                $this->setProfit($value);
                break;
            case 8:
                $this->setRoi($value);
                break;
            case 9:
                $this->setCreatedAt($value);
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
        $keys = PriceHistoryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setItemId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setBuyPrice($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSellPrice($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBuyQty($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSellQty($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHash($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setProfit($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setRoi($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCreatedAt($arr[$keys[9]]);
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
     * @return $this|\GW2Exchange\Database\PriceHistory The current object, for fluid interface
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
        $criteria = new Criteria(PriceHistoryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PriceHistoryTableMap::COL_ID)) {
            $criteria->add(PriceHistoryTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_ITEM_ID)) {
            $criteria->add(PriceHistoryTableMap::COL_ITEM_ID, $this->item_id);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_BUY_PRICE)) {
            $criteria->add(PriceHistoryTableMap::COL_BUY_PRICE, $this->buy_price);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_SELL_PRICE)) {
            $criteria->add(PriceHistoryTableMap::COL_SELL_PRICE, $this->sell_price);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_BUY_QTY)) {
            $criteria->add(PriceHistoryTableMap::COL_BUY_QTY, $this->buy_qty);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_SELL_QTY)) {
            $criteria->add(PriceHistoryTableMap::COL_SELL_QTY, $this->sell_qty);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_HASH)) {
            $criteria->add(PriceHistoryTableMap::COL_HASH, $this->hash);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_PROFIT)) {
            $criteria->add(PriceHistoryTableMap::COL_PROFIT, $this->profit);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_ROI)) {
            $criteria->add(PriceHistoryTableMap::COL_ROI, $this->roi);
        }
        if ($this->isColumnModified(PriceHistoryTableMap::COL_CREATED_AT)) {
            $criteria->add(PriceHistoryTableMap::COL_CREATED_AT, $this->created_at);
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
        $criteria = ChildPriceHistoryQuery::create();
        $criteria->add(PriceHistoryTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \GW2Exchange\Database\PriceHistory (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setItemId($this->getItemId());
        $copyObj->setBuyPrice($this->getBuyPrice());
        $copyObj->setSellPrice($this->getSellPrice());
        $copyObj->setBuyQty($this->getBuyQty());
        $copyObj->setSellQty($this->getSellQty());
        $copyObj->setHash($this->getHash());
        $copyObj->setProfit($this->getProfit());
        $copyObj->setRoi($this->getRoi());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRequestsLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRequestsLog($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \GW2Exchange\Database\PriceHistory Clone of current object.
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
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
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

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildItem object, it will not be re-added.
        if ($v !== null) {
            $v->addPriceHistory($this);
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
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aItem->addPriceHistories($this);
             */
        }

        return $this->aItem;
    }

    /**
     * Declares an association between this object and a ChildPrice object.
     *
     * @param  ChildPrice $v
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPrice(ChildPrice $v = null)
    {
        if ($v === null) {
            $this->setItemId(NULL);
        } else {
            $this->setItemId($v->getItemId());
        }

        $this->aPrice = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPrice object, it will not be re-added.
        if ($v !== null) {
            $v->addPriceHistory($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPrice object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPrice The associated ChildPrice object.
     * @throws PropelException
     */
    public function getPrice(ConnectionInterface $con = null)
    {
        if ($this->aPrice === null && ($this->item_id !== null)) {
            $this->aPrice = ChildPriceQuery::create()->findPk($this->item_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPrice->addPriceHistories($this);
             */
        }

        return $this->aPrice;
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
        if ('RequestsLog' == $relationName) {
            return $this->initRequestsLogs();
        }
    }

    /**
     * Clears out the collRequestsLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRequestsLogs()
     */
    public function clearRequestsLogs()
    {
        $this->collRequestsLogs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRequestsLogs collection loaded partially.
     */
    public function resetPartialRequestsLogs($v = true)
    {
        $this->collRequestsLogsPartial = $v;
    }

    /**
     * Initializes the collRequestsLogs collection.
     *
     * By default this just sets the collRequestsLogs collection to an empty array (like clearcollRequestsLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRequestsLogs($overrideExisting = true)
    {
        if (null !== $this->collRequestsLogs && !$overrideExisting) {
            return;
        }
        $this->collRequestsLogs = new ObjectCollection();
        $this->collRequestsLogs->setModel('\GW2Exchange\Database\RequestsLog');
    }

    /**
     * Gets an array of ChildRequestsLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPriceHistory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRequestsLog[] List of ChildRequestsLog objects
     * @throws PropelException
     */
    public function getRequestsLogs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestsLogsPartial && !$this->isNew();
        if (null === $this->collRequestsLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRequestsLogs) {
                // return empty collection
                $this->initRequestsLogs();
            } else {
                $collRequestsLogs = ChildRequestsLogQuery::create(null, $criteria)
                    ->filterByPriceHistory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRequestsLogsPartial && count($collRequestsLogs)) {
                        $this->initRequestsLogs(false);

                        foreach ($collRequestsLogs as $obj) {
                            if (false == $this->collRequestsLogs->contains($obj)) {
                                $this->collRequestsLogs->append($obj);
                            }
                        }

                        $this->collRequestsLogsPartial = true;
                    }

                    return $collRequestsLogs;
                }

                if ($partial && $this->collRequestsLogs) {
                    foreach ($this->collRequestsLogs as $obj) {
                        if ($obj->isNew()) {
                            $collRequestsLogs[] = $obj;
                        }
                    }
                }

                $this->collRequestsLogs = $collRequestsLogs;
                $this->collRequestsLogsPartial = false;
            }
        }

        return $this->collRequestsLogs;
    }

    /**
     * Sets a collection of ChildRequestsLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $requestsLogs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPriceHistory The current object (for fluent API support)
     */
    public function setRequestsLogs(Collection $requestsLogs, ConnectionInterface $con = null)
    {
        /** @var ChildRequestsLog[] $requestsLogsToDelete */
        $requestsLogsToDelete = $this->getRequestsLogs(new Criteria(), $con)->diff($requestsLogs);


        $this->requestsLogsScheduledForDeletion = $requestsLogsToDelete;

        foreach ($requestsLogsToDelete as $requestsLogRemoved) {
            $requestsLogRemoved->setPriceHistory(null);
        }

        $this->collRequestsLogs = null;
        foreach ($requestsLogs as $requestsLog) {
            $this->addRequestsLog($requestsLog);
        }

        $this->collRequestsLogs = $requestsLogs;
        $this->collRequestsLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RequestsLog objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RequestsLog objects.
     * @throws PropelException
     */
    public function countRequestsLogs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestsLogsPartial && !$this->isNew();
        if (null === $this->collRequestsLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRequestsLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRequestsLogs());
            }

            $query = ChildRequestsLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPriceHistory($this)
                ->count($con);
        }

        return count($this->collRequestsLogs);
    }

    /**
     * Method called to associate a ChildRequestsLog object to this object
     * through the ChildRequestsLog foreign key attribute.
     *
     * @param  ChildRequestsLog $l ChildRequestsLog
     * @return $this|\GW2Exchange\Database\PriceHistory The current object (for fluent API support)
     */
    public function addRequestsLog(ChildRequestsLog $l)
    {
        if ($this->collRequestsLogs === null) {
            $this->initRequestsLogs();
            $this->collRequestsLogsPartial = true;
        }

        if (!$this->collRequestsLogs->contains($l)) {
            $this->doAddRequestsLog($l);
        }

        return $this;
    }

    /**
     * @param ChildRequestsLog $requestsLog The ChildRequestsLog object to add.
     */
    protected function doAddRequestsLog(ChildRequestsLog $requestsLog)
    {
        $this->collRequestsLogs[]= $requestsLog;
        $requestsLog->setPriceHistory($this);
    }

    /**
     * @param  ChildRequestsLog $requestsLog The ChildRequestsLog object to remove.
     * @return $this|ChildPriceHistory The current object (for fluent API support)
     */
    public function removeRequestsLog(ChildRequestsLog $requestsLog)
    {
        if ($this->getRequestsLogs()->contains($requestsLog)) {
            $pos = $this->collRequestsLogs->search($requestsLog);
            $this->collRequestsLogs->remove($pos);
            if (null === $this->requestsLogsScheduledForDeletion) {
                $this->requestsLogsScheduledForDeletion = clone $this->collRequestsLogs;
                $this->requestsLogsScheduledForDeletion->clear();
            }
            $this->requestsLogsScheduledForDeletion[]= clone $requestsLog;
            $requestsLog->setPriceHistory(null);
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
        if (null !== $this->aItem) {
            $this->aItem->removePriceHistory($this);
        }
        if (null !== $this->aPrice) {
            $this->aPrice->removePriceHistory($this);
        }
        $this->id = null;
        $this->item_id = null;
        $this->buy_price = null;
        $this->sell_price = null;
        $this->buy_qty = null;
        $this->sell_qty = null;
        $this->hash = null;
        $this->profit = null;
        $this->roi = null;
        $this->created_at = null;
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
            if ($this->collRequestsLogs) {
                foreach ($this->collRequestsLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRequestsLogs = null;
        $this->aItem = null;
        $this->aPrice = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PriceHistoryTableMap::DEFAULT_STRING_FORMAT);
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
