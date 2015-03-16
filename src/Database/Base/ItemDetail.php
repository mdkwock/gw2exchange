<?php

namespace GW2ledger\Database\Base;

use \Exception;
use \PDO;
use GW2ledger\Database\Item as ChildItem;
use GW2ledger\Database\ItemDetail as ChildItemDetail;
use GW2ledger\Database\ItemDetailQuery as ChildItemDetailQuery;
use GW2ledger\Database\ItemItemDetail as ChildItemItemDetail;
use GW2ledger\Database\ItemItemDetailQuery as ChildItemItemDetailQuery;
use GW2ledger\Database\ItemQuery as ChildItemQuery;
use GW2ledger\Database\Map\ItemDetailTableMap;
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

/**
 * Base class that represents a row from the 'item_detail' table.
 *
 *
 *
* @package    propel.generator.GW2ledger.Database.Base
*/
abstract class ItemDetail implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\GW2ledger\\Database\\Map\\ItemDetailTableMap';


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
     * The value for the item_type field.
     * @var        string
     */
    protected $item_type;

    /**
     * The value for the label field.
     * @var        string
     */
    protected $label;

    /**
     * The value for the value_type field.
     * @var        string
     */
    protected $value_type;

    /**
     * @var        ObjectCollection|ChildItemItemDetail[] Collection to store aggregation of ChildItemItemDetail objects.
     */
    protected $collItemItemDetails;
    protected $collItemItemDetailsPartial;

    /**
     * @var        ObjectCollection|ChildItem[] Cross Collection to store aggregation of ChildItem objects.
     */
    protected $collItems;

    /**
     * @var bool
     */
    protected $collItemsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItem[]
     */
    protected $itemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItemItemDetail[]
     */
    protected $itemItemDetailsScheduledForDeletion = null;

    /**
     * Initializes internal state of GW2ledger\Database\Base\ItemDetail object.
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
     * Compares this with another <code>ItemDetail</code> instance.  If
     * <code>obj</code> is an instance of <code>ItemDetail</code>, delegates to
     * <code>equals(ItemDetail)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ItemDetail The current object, for fluid interface
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
     * Get the [item_type] column value.
     *
     * @return string
     */
    public function getItemType()
    {
        return $this->item_type;
    }

    /**
     * Get the [label] column value.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the [value_type] column value.
     *
     * @return string
     */
    public function getValueType()
    {
        return $this->value_type;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\GW2ledger\Database\ItemDetail The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ItemDetailTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [item_type] column.
     *
     * @param string $v new value
     * @return $this|\GW2ledger\Database\ItemDetail The current object (for fluent API support)
     */
    public function setItemType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_type !== $v) {
            $this->item_type = $v;
            $this->modifiedColumns[ItemDetailTableMap::COL_ITEM_TYPE] = true;
        }

        return $this;
    } // setItemType()

    /**
     * Set the value of [label] column.
     *
     * @param string $v new value
     * @return $this|\GW2ledger\Database\ItemDetail The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[ItemDetailTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [value_type] column.
     *
     * @param string $v new value
     * @return $this|\GW2ledger\Database\ItemDetail The current object (for fluent API support)
     */
    public function setValueType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->value_type !== $v) {
            $this->value_type = $v;
            $this->modifiedColumns[ItemDetailTableMap::COL_VALUE_TYPE] = true;
        }

        return $this;
    } // setValueType()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemDetailTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemDetailTableMap::translateFieldName('ItemType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemDetailTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemDetailTableMap::translateFieldName('ValueType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value_type = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = ItemDetailTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\GW2ledger\\Database\\ItemDetail'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ItemDetailTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemDetailQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collItemItemDetails = null;

            $this->collItems = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ItemDetail::setDeleted()
     * @see ItemDetail::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemDetailQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
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
                ItemDetailTableMap::addInstanceToPool($this);
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

            if ($this->itemsScheduledForDeletion !== null) {
                if (!$this->itemsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->itemsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \GW2ledger\Database\ItemItemDetailQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->itemsScheduledForDeletion = null;
                }

            }

            if ($this->collItems) {
                foreach ($this->collItems as $item) {
                    if (!$item->isDeleted() && ($item->isNew() || $item->isModified())) {
                        $item->save($con);
                    }
                }
            }


            if ($this->itemItemDetailsScheduledForDeletion !== null) {
                if (!$this->itemItemDetailsScheduledForDeletion->isEmpty()) {
                    \GW2ledger\Database\ItemItemDetailQuery::create()
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

        $this->modifiedColumns[ItemDetailTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemDetailTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemDetailTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ItemDetailTableMap::COL_ITEM_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'item_type';
        }
        if ($this->isColumnModified(ItemDetailTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(ItemDetailTableMap::COL_VALUE_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'value_type';
        }

        $sql = sprintf(
            'INSERT INTO item_detail (%s) VALUES (%s)',
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
                    case 'item_type':
                        $stmt->bindValue($identifier, $this->item_type, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'value_type':
                        $stmt->bindValue($identifier, $this->value_type, PDO::PARAM_STR);
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
        $pos = ItemDetailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemType();
                break;
            case 2:
                return $this->getLabel();
                break;
            case 3:
                return $this->getValueType();
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

        if (isset($alreadyDumpedObjects['ItemDetail'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ItemDetail'][$this->hashCode()] = true;
        $keys = ItemDetailTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getItemType(),
            $keys[2] => $this->getLabel(),
            $keys[3] => $this->getValueType(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\GW2ledger\Database\ItemDetail
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemDetailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\GW2ledger\Database\ItemDetail
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setItemType($value);
                break;
            case 2:
                $this->setLabel($value);
                break;
            case 3:
                $this->setValueType($value);
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
        $keys = ItemDetailTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setItemType($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLabel($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setValueType($arr[$keys[3]]);
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
     * @return $this|\GW2ledger\Database\ItemDetail The current object, for fluid interface
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
        $criteria = new Criteria(ItemDetailTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemDetailTableMap::COL_ID)) {
            $criteria->add(ItemDetailTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ItemDetailTableMap::COL_ITEM_TYPE)) {
            $criteria->add(ItemDetailTableMap::COL_ITEM_TYPE, $this->item_type);
        }
        if ($this->isColumnModified(ItemDetailTableMap::COL_LABEL)) {
            $criteria->add(ItemDetailTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(ItemDetailTableMap::COL_VALUE_TYPE)) {
            $criteria->add(ItemDetailTableMap::COL_VALUE_TYPE, $this->value_type);
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
        $criteria = ChildItemDetailQuery::create();
        $criteria->add(ItemDetailTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \GW2ledger\Database\ItemDetail (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setItemType($this->getItemType());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setValueType($this->getValueType());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getItemItemDetails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItemItemDetail($relObj->copy($deepCopy));
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
     * @return \GW2ledger\Database\ItemDetail Clone of current object.
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
        $this->collItemItemDetails->setModel('\GW2ledger\Database\ItemItemDetail');
    }

    /**
     * Gets an array of ChildItemItemDetail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItemDetail is new, it will return
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
                    ->filterByItemDetail($this)
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
     * @return $this|ChildItemDetail The current object (for fluent API support)
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
            $itemItemDetailRemoved->setItemDetail(null);
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
                ->filterByItemDetail($this)
                ->count($con);
        }

        return count($this->collItemItemDetails);
    }

    /**
     * Method called to associate a ChildItemItemDetail object to this object
     * through the ChildItemItemDetail foreign key attribute.
     *
     * @param  ChildItemItemDetail $l ChildItemItemDetail
     * @return $this|\GW2ledger\Database\ItemDetail The current object (for fluent API support)
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
        $itemItemDetail->setItemDetail($this);
    }

    /**
     * @param  ChildItemItemDetail $itemItemDetail The ChildItemItemDetail object to remove.
     * @return $this|ChildItemDetail The current object (for fluent API support)
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
            $itemItemDetail->setItemDetail(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ItemDetail is new, it will return
     * an empty collection; or if this ItemDetail has previously
     * been saved, it will retrieve related ItemItemDetails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ItemDetail.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItemItemDetail[] List of ChildItemItemDetail objects
     */
    public function getItemItemDetailsJoinItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemItemDetailQuery::create(null, $criteria);
        $query->joinWith('Item', $joinBehavior);

        return $this->getItemItemDetails($query, $con);
    }

    /**
     * Clears out the collItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItems()
     */
    public function clearItems()
    {
        $this->collItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collItems crossRef collection.
     *
     * By default this just sets the collItems collection to an empty collection (like clearItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initItems()
    {
        $this->collItems = new ObjectCollection();
        $this->collItemsPartial = true;

        $this->collItems->setModel('\GW2ledger\Database\Item');
    }

    /**
     * Checks if the collItems collection is loaded.
     *
     * @return bool
     */
    public function isItemsLoaded()
    {
        return null !== $this->collItems;
    }

    /**
     * Gets a collection of ChildItem objects related by a many-to-many relationship
     * to the current object by way of the item_item_detail cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItemDetail is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     */
    public function getItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collItems) {
                    $this->initItems();
                }
            } else {

                $query = ChildItemQuery::create(null, $criteria)
                    ->filterByItemDetail($this);
                $collItems = $query->find($con);
                if (null !== $criteria) {
                    return $collItems;
                }

                if ($partial && $this->collItems) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collItems as $obj) {
                        if (!$collItems->contains($obj)) {
                            $collItems[] = $obj;
                        }
                    }
                }

                $this->collItems = $collItems;
                $this->collItemsPartial = false;
            }
        }

        return $this->collItems;
    }

    /**
     * Sets a collection of Item objects related by a many-to-many relationship
     * to the current object by way of the item_item_detail cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $items A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildItemDetail The current object (for fluent API support)
     */
    public function setItems(Collection $items, ConnectionInterface $con = null)
    {
        $this->clearItems();
        $currentItems = $this->getItems();

        $itemsScheduledForDeletion = $currentItems->diff($items);

        foreach ($itemsScheduledForDeletion as $toDelete) {
            $this->removeItem($toDelete);
        }

        foreach ($items as $item) {
            if (!$currentItems->contains($item)) {
                $this->doAddItem($item);
            }
        }

        $this->collItemsPartial = false;
        $this->collItems = $items;

        return $this;
    }

    /**
     * Gets the number of Item objects related by a many-to-many relationship
     * to the current object by way of the item_item_detail cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Item objects
     */
    public function countItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getItems());
                }

                $query = ChildItemQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByItemDetail($this)
                    ->count($con);
            }
        } else {
            return count($this->collItems);
        }
    }

    /**
     * Associate a ChildItem to this object
     * through the item_item_detail cross reference table.
     *
     * @param ChildItem $item
     * @return ChildItemDetail The current object (for fluent API support)
     */
    public function addItem(ChildItem $item)
    {
        if ($this->collItems === null) {
            $this->initItems();
        }

        if (!$this->getItems()->contains($item)) {
            // only add it if the **same** object is not already associated
            $this->collItems->push($item);
            $this->doAddItem($item);
        }

        return $this;
    }

    /**
     *
     * @param ChildItem $item
     */
    protected function doAddItem(ChildItem $item)
    {
        $itemItemDetail = new ChildItemItemDetail();

        $itemItemDetail->setItem($item);

        $itemItemDetail->setItemDetail($this);

        $this->addItemItemDetail($itemItemDetail);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$item->isItemDetailsLoaded()) {
            $item->initItemDetails();
            $item->getItemDetails()->push($this);
        } elseif (!$item->getItemDetails()->contains($this)) {
            $item->getItemDetails()->push($this);
        }

    }

    /**
     * Remove item of this object
     * through the item_item_detail cross reference table.
     *
     * @param ChildItem $item
     * @return ChildItemDetail The current object (for fluent API support)
     */
    public function removeItem(ChildItem $item)
    {
        if ($this->getItems()->contains($item)) { $itemItemDetail = new ChildItemItemDetail();

            $itemItemDetail->setItem($item);
            if ($item->isItemDetailsLoaded()) {
                //remove the back reference if available
                $item->getItemDetails()->removeObject($this);
            }

            $itemItemDetail->setItemDetail($this);
            $this->removeItemItemDetail(clone $itemItemDetail);
            $itemItemDetail->clear();

            $this->collItems->remove($this->collItems->search($item));

            if (null === $this->itemsScheduledForDeletion) {
                $this->itemsScheduledForDeletion = clone $this->collItems;
                $this->itemsScheduledForDeletion->clear();
            }

            $this->itemsScheduledForDeletion->push($item);
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
        $this->item_type = null;
        $this->label = null;
        $this->value_type = null;
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
            if ($this->collItemItemDetails) {
                foreach ($this->collItemItemDetails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItems) {
                foreach ($this->collItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collItemItemDetails = null;
        $this->collItems = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemDetailTableMap::DEFAULT_STRING_FORMAT);
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