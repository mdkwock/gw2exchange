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
use GW2Exchange\Database\Map\PriceTableMap;
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
 * Base class that represents a row from the 'price' table.
 *
 *
 *
* @package    propel.generator.GW2Exchange.Database.Base
*/
abstract class Price implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\GW2Exchange\\Database\\Map\\PriceTableMap';


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
     * The value for the cache_time field.
     * @var        int
     */
    protected $cache_time;

    /**
     * The value for the max_buy field.
     * @var        int
     */
    protected $max_buy;

    /**
     * The value for the min_buy field.
     * @var        int
     */
    protected $min_buy;

    /**
     * The value for the max_sell field.
     * @var        int
     */
    protected $max_sell;

    /**
     * The value for the min_sell field.
     * @var        int
     */
    protected $min_sell;

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
     * @var        ChildItem
     */
    protected $aItem;

    /**
     * @var        ObjectCollection|ChildPriceHistory[] Collection to store aggregation of ChildPriceHistory objects.
     */
    protected $collPriceHistories;
    protected $collPriceHistoriesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPriceHistory[]
     */
    protected $priceHistoriesScheduledForDeletion = null;

    /**
     * Initializes internal state of GW2Exchange\Database\Base\Price object.
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
     * Compares this with another <code>Price</code> instance.  If
     * <code>obj</code> is an instance of <code>Price</code>, delegates to
     * <code>equals(Price)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Price The current object, for fluid interface
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
     * Get the [cache_time] column value.
     *
     * @return int
     */
    public function getCacheTime()
    {
        return $this->cache_time;
    }

    /**
     * Get the [max_buy] column value.
     *
     * @return int
     */
    public function getMaxBuy()
    {
        return $this->max_buy;
    }

    /**
     * Get the [min_buy] column value.
     *
     * @return int
     */
    public function getMinBuy()
    {
        return $this->min_buy;
    }

    /**
     * Get the [max_sell] column value.
     *
     * @return int
     */
    public function getMaxSell()
    {
        return $this->max_sell;
    }

    /**
     * Get the [min_sell] column value.
     *
     * @return int
     */
    public function getMinSell()
    {
        return $this->min_sell;
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
     * Set the value of [item_id] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[PriceTableMap::COL_ITEM_ID] = true;
        }

        if ($this->aItem !== null && $this->aItem->getId() !== $v) {
            $this->aItem = null;
        }

        return $this;
    } // setItemId()

    /**
     * Set the value of [buy_price] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setBuyPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy_price !== $v) {
            $this->buy_price = $v;
            $this->modifiedColumns[PriceTableMap::COL_BUY_PRICE] = true;
        }

        return $this;
    } // setBuyPrice()

    /**
     * Set the value of [sell_price] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setSellPrice($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_price !== $v) {
            $this->sell_price = $v;
            $this->modifiedColumns[PriceTableMap::COL_SELL_PRICE] = true;
        }

        return $this;
    } // setSellPrice()

    /**
     * Set the value of [buy_qty] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setBuyQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->buy_qty !== $v) {
            $this->buy_qty = $v;
            $this->modifiedColumns[PriceTableMap::COL_BUY_QTY] = true;
        }

        return $this;
    } // setBuyQty()

    /**
     * Set the value of [sell_qty] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setSellQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sell_qty !== $v) {
            $this->sell_qty = $v;
            $this->modifiedColumns[PriceTableMap::COL_SELL_QTY] = true;
        }

        return $this;
    } // setSellQty()

    /**
     * Set the value of [cache_time] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setCacheTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cache_time !== $v) {
            $this->cache_time = $v;
            $this->modifiedColumns[PriceTableMap::COL_CACHE_TIME] = true;
        }

        return $this;
    } // setCacheTime()

    /**
     * Set the value of [max_buy] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setMaxBuy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->max_buy !== $v) {
            $this->max_buy = $v;
            $this->modifiedColumns[PriceTableMap::COL_MAX_BUY] = true;
        }

        return $this;
    } // setMaxBuy()

    /**
     * Set the value of [min_buy] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setMinBuy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->min_buy !== $v) {
            $this->min_buy = $v;
            $this->modifiedColumns[PriceTableMap::COL_MIN_BUY] = true;
        }

        return $this;
    } // setMinBuy()

    /**
     * Set the value of [max_sell] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setMaxSell($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->max_sell !== $v) {
            $this->max_sell = $v;
            $this->modifiedColumns[PriceTableMap::COL_MAX_SELL] = true;
        }

        return $this;
    } // setMaxSell()

    /**
     * Set the value of [min_sell] column.
     *
     * @param int $v new value
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setMinSell($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->min_sell !== $v) {
            $this->min_sell = $v;
            $this->modifiedColumns[PriceTableMap::COL_MIN_SELL] = true;
        }

        return $this;
    } // setMinSell()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PriceTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PriceTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PriceTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PriceTableMap::translateFieldName('BuyPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PriceTableMap::translateFieldName('SellPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_price = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PriceTableMap::translateFieldName('BuyQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buy_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PriceTableMap::translateFieldName('SellQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sell_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PriceTableMap::translateFieldName('CacheTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cache_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PriceTableMap::translateFieldName('MaxBuy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->max_buy = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PriceTableMap::translateFieldName('MinBuy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->min_buy = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PriceTableMap::translateFieldName('MaxSell', TableMap::TYPE_PHPNAME, $indexType)];
            $this->max_sell = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PriceTableMap::translateFieldName('MinSell', TableMap::TYPE_PHPNAME, $indexType)];
            $this->min_sell = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PriceTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PriceTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = PriceTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\GW2Exchange\\Database\\Price'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PriceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPriceQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aItem = null;
            $this->collPriceHistories = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Price::setDeleted()
     * @see Price::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPriceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(PriceTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(PriceTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(PriceTableMap::COL_UPDATED_AT)) {
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
                PriceTableMap::addInstanceToPool($this);
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
        if ($this->isColumnModified(PriceTableMap::COL_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_id';
        }
        if ($this->isColumnModified(PriceTableMap::COL_BUY_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'buy_price';
        }
        if ($this->isColumnModified(PriceTableMap::COL_SELL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'sell_price';
        }
        if ($this->isColumnModified(PriceTableMap::COL_BUY_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'buy_qty';
        }
        if ($this->isColumnModified(PriceTableMap::COL_SELL_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'sell_qty';
        }
        if ($this->isColumnModified(PriceTableMap::COL_CACHE_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'cache_time';
        }
        if ($this->isColumnModified(PriceTableMap::COL_MAX_BUY)) {
            $modifiedColumns[':p' . $index++]  = 'max_buy';
        }
        if ($this->isColumnModified(PriceTableMap::COL_MIN_BUY)) {
            $modifiedColumns[':p' . $index++]  = 'min_buy';
        }
        if ($this->isColumnModified(PriceTableMap::COL_MAX_SELL)) {
            $modifiedColumns[':p' . $index++]  = 'max_sell';
        }
        if ($this->isColumnModified(PriceTableMap::COL_MIN_SELL)) {
            $modifiedColumns[':p' . $index++]  = 'min_sell';
        }
        if ($this->isColumnModified(PriceTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(PriceTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO price (%s) VALUES (%s)',
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
                    case 'cache_time':
                        $stmt->bindValue($identifier, $this->cache_time, PDO::PARAM_INT);
                        break;
                    case 'max_buy':
                        $stmt->bindValue($identifier, $this->max_buy, PDO::PARAM_INT);
                        break;
                    case 'min_buy':
                        $stmt->bindValue($identifier, $this->min_buy, PDO::PARAM_INT);
                        break;
                    case 'max_sell':
                        $stmt->bindValue($identifier, $this->max_sell, PDO::PARAM_INT);
                        break;
                    case 'min_sell':
                        $stmt->bindValue($identifier, $this->min_sell, PDO::PARAM_INT);
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
        $pos = PriceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getBuyPrice();
                break;
            case 2:
                return $this->getSellPrice();
                break;
            case 3:
                return $this->getBuyQty();
                break;
            case 4:
                return $this->getSellQty();
                break;
            case 5:
                return $this->getCacheTime();
                break;
            case 6:
                return $this->getMaxBuy();
                break;
            case 7:
                return $this->getMinBuy();
                break;
            case 8:
                return $this->getMaxSell();
                break;
            case 9:
                return $this->getMinSell();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
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

        if (isset($alreadyDumpedObjects['Price'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Price'][$this->hashCode()] = true;
        $keys = PriceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemId(),
            $keys[1] => $this->getBuyPrice(),
            $keys[2] => $this->getSellPrice(),
            $keys[3] => $this->getBuyQty(),
            $keys[4] => $this->getSellQty(),
            $keys[5] => $this->getCacheTime(),
            $keys[6] => $this->getMaxBuy(),
            $keys[7] => $this->getMinBuy(),
            $keys[8] => $this->getMaxSell(),
            $keys[9] => $this->getMinSell(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[10]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[10]];
            $result[$keys[10]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[11]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[11]];
            $result[$keys[11]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
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
     * @return $this|\GW2Exchange\Database\Price
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PriceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\GW2Exchange\Database\Price
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemId($value);
                break;
            case 1:
                $this->setBuyPrice($value);
                break;
            case 2:
                $this->setSellPrice($value);
                break;
            case 3:
                $this->setBuyQty($value);
                break;
            case 4:
                $this->setSellQty($value);
                break;
            case 5:
                $this->setCacheTime($value);
                break;
            case 6:
                $this->setMaxBuy($value);
                break;
            case 7:
                $this->setMinBuy($value);
                break;
            case 8:
                $this->setMaxSell($value);
                break;
            case 9:
                $this->setMinSell($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
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
        $keys = PriceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setBuyPrice($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSellPrice($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBuyQty($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSellQty($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCacheTime($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMaxBuy($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setMinBuy($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setMaxSell($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setMinSell($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
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
     * @return $this|\GW2Exchange\Database\Price The current object, for fluid interface
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
        $criteria = new Criteria(PriceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PriceTableMap::COL_ITEM_ID)) {
            $criteria->add(PriceTableMap::COL_ITEM_ID, $this->item_id);
        }
        if ($this->isColumnModified(PriceTableMap::COL_BUY_PRICE)) {
            $criteria->add(PriceTableMap::COL_BUY_PRICE, $this->buy_price);
        }
        if ($this->isColumnModified(PriceTableMap::COL_SELL_PRICE)) {
            $criteria->add(PriceTableMap::COL_SELL_PRICE, $this->sell_price);
        }
        if ($this->isColumnModified(PriceTableMap::COL_BUY_QTY)) {
            $criteria->add(PriceTableMap::COL_BUY_QTY, $this->buy_qty);
        }
        if ($this->isColumnModified(PriceTableMap::COL_SELL_QTY)) {
            $criteria->add(PriceTableMap::COL_SELL_QTY, $this->sell_qty);
        }
        if ($this->isColumnModified(PriceTableMap::COL_CACHE_TIME)) {
            $criteria->add(PriceTableMap::COL_CACHE_TIME, $this->cache_time);
        }
        if ($this->isColumnModified(PriceTableMap::COL_MAX_BUY)) {
            $criteria->add(PriceTableMap::COL_MAX_BUY, $this->max_buy);
        }
        if ($this->isColumnModified(PriceTableMap::COL_MIN_BUY)) {
            $criteria->add(PriceTableMap::COL_MIN_BUY, $this->min_buy);
        }
        if ($this->isColumnModified(PriceTableMap::COL_MAX_SELL)) {
            $criteria->add(PriceTableMap::COL_MAX_SELL, $this->max_sell);
        }
        if ($this->isColumnModified(PriceTableMap::COL_MIN_SELL)) {
            $criteria->add(PriceTableMap::COL_MIN_SELL, $this->min_sell);
        }
        if ($this->isColumnModified(PriceTableMap::COL_CREATED_AT)) {
            $criteria->add(PriceTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(PriceTableMap::COL_UPDATED_AT)) {
            $criteria->add(PriceTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildPriceQuery::create();
        $criteria->add(PriceTableMap::COL_ITEM_ID, $this->item_id);

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

        //relation price_fk_5cf635 to table item
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
     * @param      object $copyObj An object of \GW2Exchange\Database\Price (or compatible) type.
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
        $copyObj->setCacheTime($this->getCacheTime());
        $copyObj->setMaxBuy($this->getMaxBuy());
        $copyObj->setMinBuy($this->getMinBuy());
        $copyObj->setMaxSell($this->getMaxSell());
        $copyObj->setMinSell($this->getMinSell());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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
     * @return \GW2Exchange\Database\Price Clone of current object.
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
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
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
            $v->setPrice($this);
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
            $this->aItem->setPrice($this);
        }

        return $this->aItem;
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
        if ('PriceHistory' == $relationName) {
            return $this->initPriceHistories();
        }
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
     * If this ChildPrice is new, it will return
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
                    ->filterByPrice($this)
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
     * @return $this|ChildPrice The current object (for fluent API support)
     */
    public function setPriceHistories(Collection $priceHistories, ConnectionInterface $con = null)
    {
        /** @var ChildPriceHistory[] $priceHistoriesToDelete */
        $priceHistoriesToDelete = $this->getPriceHistories(new Criteria(), $con)->diff($priceHistories);


        $this->priceHistoriesScheduledForDeletion = $priceHistoriesToDelete;

        foreach ($priceHistoriesToDelete as $priceHistoryRemoved) {
            $priceHistoryRemoved->setPrice(null);
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
                ->filterByPrice($this)
                ->count($con);
        }

        return count($this->collPriceHistories);
    }

    /**
     * Method called to associate a ChildPriceHistory object to this object
     * through the ChildPriceHistory foreign key attribute.
     *
     * @param  ChildPriceHistory $l ChildPriceHistory
     * @return $this|\GW2Exchange\Database\Price The current object (for fluent API support)
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
        $priceHistory->setPrice($this);
    }

    /**
     * @param  ChildPriceHistory $priceHistory The ChildPriceHistory object to remove.
     * @return $this|ChildPrice The current object (for fluent API support)
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
            $priceHistory->setPrice(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Price is new, it will return
     * an empty collection; or if this Price has previously
     * been saved, it will retrieve related PriceHistories from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Price.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPriceHistory[] List of ChildPriceHistory objects
     */
    public function getPriceHistoriesJoinItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPriceHistoryQuery::create(null, $criteria);
        $query->joinWith('Item', $joinBehavior);

        return $this->getPriceHistories($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aItem) {
            $this->aItem->removePrice($this);
        }
        $this->item_id = null;
        $this->buy_price = null;
        $this->sell_price = null;
        $this->buy_qty = null;
        $this->sell_qty = null;
        $this->cache_time = null;
        $this->max_buy = null;
        $this->min_buy = null;
        $this->max_sell = null;
        $this->min_sell = null;
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
            if ($this->collPriceHistories) {
                foreach ($this->collPriceHistories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPriceHistories = null;
        $this->aItem = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PriceTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildPrice The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[PriceTableMap::COL_UPDATED_AT] = true;

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
