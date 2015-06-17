<?php
namespace GW2Exchange\Database;

use GW2Exchange\Database\Base\ItemInfo as BaseItemInfo;
use GW2Exchange\Database\Map\ItemInfoTableMap;
use GW2Exchange\Signature\Database\DatabaseObjectInterface;

/**
 * Skeleton subclass for representing a row from the 'info' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ItemInfo extends BaseItemInfo implements DatabaseObjectInterface
{
  protected static $tableColumnMap;

  /**
   * this function is used as a shortcut to the propel table mapping process
   * will return an array of all of the columns that are controlled by this object
   * @return string[]     all of the fields that this object has
   */
  public function getFields()
  {
    if(empty(static::$tableColumnMap)){
      //if we have not already generated a map
      $baseItemTable = ItemInfoTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * sets all of the info using parameters
   * @param  int     $item_id       the id of the item
   * @param  string  $description   the description of the item
   * @param  string  $type          the item type, determines the details
   * @param  string  $rarity        how rare the item is
   * @param  int     $level         the required level to use this item
   * @param  int     $vendor_value  how much a vendor will pay for it
   * @param  int     $default_skin  the default skin
   * @param  string  $flags         all of the item flags
   * @param  string  $game_types    the game types you can use the item in (pve,wvw,pvp)
   * @param  string  $restrictions  what restrictions are on this item
   * @return ItemInfo
   */
  public function setAll($item_id,$description,$type,$rarity,$level,$vendor_value,$default_skin,$flags,$game_types,$restrictions)
  {
    $this->setItemId($item_id);
    if(!empty($description)){
      //only fill the description if it is set
      $this->setDescription($description);
    }
    $this->setType($type);
    $this->setRarity($rarity);
    $this->setLevel($level);
    $this->setVendorValue($vendor_value);
    if(!empty($default_skin)){
      //only fill the description if it is set
      $this->setDefaultSkin($default_skin);
    }

    //flags is an array of strings, so serialize them
    $flagsStr = serialize($flags);
    $this->setFlags($flagsStr);

    //game_types is an array of strings
    $gameTypesStr = serialize($game_types);
    $this->setGameTypes($gameTypesStr);

    //restrictions is an array of strings
    $restrictionsStr = serialize($restrictions);
    $this->setRestrictions($restrictionsStr);
  }
  
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   */
  public function setAllFromArray($attributes)
  {
    //description is optional so set it to null if it does not exist
    $attributes['Description'] = empty($attributes['Description'])?null:$attributes['Description'];
    $attributes['DefaultSkin'] = empty($attributes['DefaultSkin'])?null:$attributes['DefaultSkin'];
    return $this->setAll($attributes['Id'],$attributes['Description'],$attributes['Type'],$attributes['Rarity'],$attributes['Level'],$attributes['VendorValue'],$attributes['DefaultSkin'],$attributes['Flags'],$attributes['GameTypes'],$attributes['Restrictions']);
  }

  public function getFlags(){
    $flagsStr = parent::getFlags();
    $flags = unserialize($flagsStr);
    return $flags;
  }

  public function getGameTypes(){
    $gameTypesStr = parent::getGameTypes();
    $game_types = unserialize($gameTypesStr);
    return $game_types;
  }

  public function getRestrictions(){
    $restrictionsStr = parent::getRestrictions();
    $restrictions = unserialize($restrictionsStr);
    return $restrictions;
  }
}