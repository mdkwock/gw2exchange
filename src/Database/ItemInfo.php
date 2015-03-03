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
  public function __construct($item_id,$description,$type,$rarity,$level,$vendor_value,$default_skin,$flags,$game_types,$restrictions)
  {
    $this->item_id = $item_id;
    $this->description = $description;
    $this->type = $type;
    $this->rarity = $rarity;
    $this->level = $level;
    $this->vendor_value = $vendor_value;
    $this->default_skin = $default_skin;
    $this->flags = $flags;
    $this->game_types = $game_types;
    $this->restrictions = $restrictions;
  }
  
  /**
   * creates an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public static function create($attributes)
  {
    //description is optional so set it to null if it does not exist
    $attributes['description'] = empty($attributes['description'])?null:$attributes['description'];
    return new static($attributes['id'],$attributes['description'],$attributes['type'],$attributes['rarity'],$attributes['level'],$attributes['vendor_value'],$attributes['default_skin'],$attributes['flags'],$attributes['game_types'],$attributes['restrictions']);
  }
}
