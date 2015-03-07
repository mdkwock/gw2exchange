<?php
namespace GW2ledger\Database;

use GW2ledger\Database\Base\ItemInfo as BaseItemInfo;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

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
  /**
   * creates the info using parameters
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
  public static function create($item_id,$description,$type,$rarity,$level,$vendor_value,$default_skin,$flags,$game_types,$restrictions)
  {
    $obj = new static();
    $obj->setItemId($item_id);
    if(!empty($description)){
      //only fill the description if it is set
      $obj->setDescription($description);
    }
    $obj->setType($type);
    $obj->setRarity($rarity);
    $obj->setLevel($level);
    $obj->setVendorValue($vendor_value);
    if(!empty($default_skin)){
      //only fill the description if it is set
      $obj->setDefaultSkin($default_skin);
    }

    //flags is an array of strings, so serialize them
    $flagsStr = serialize($flags);
    $obj->setFlags($flagsStr);

    //game_types is an array of strings
    $gameTypesStr = serialize($game_types);
    $obj->setGameTypes($gameTypesStr);

    //restrictions is an array of strings
    $restrictionsStr = serialize($restrictions);
    $obj->setRestrictions($restrictionsStr);
    return $obj;
  }
  
  /**
   * creates an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public static function createFromArray($attributes)
  {
    //description is optional so set it to null if it does not exist
    $attributes['description'] = empty($attributes['description'])?null:$attributes['description'];
    $attributes['default_skin'] = empty($attributes['default_skin'])?null:$attributes['default_skin'];
    return static::create($attributes['id'],$attributes['description'],$attributes['type'],$attributes['rarity'],$attributes['level'],$attributes['vendor_value'],$attributes['default_skin'],$attributes['flags'],$attributes['game_types'],$attributes['restrictions']);
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