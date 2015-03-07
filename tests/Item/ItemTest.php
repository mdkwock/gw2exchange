<?php

use GW2ledger\Item\ItemParser;
use GW2ledger\Database\Item;
use GW2ledger\Item\ItemFactory;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

class ItemTest extends PHPUnit_Framework_TestCase
{

  public function testCreateFromArray()
  {
    $attributes = array ( 
      'name' => 'MONSTER ONLY Moa Unarmed Pet',
      'type' => 'Weapon', 
      'level' => 0,
      'rarity' => 'Fine',
      'vendor_value' => 0,
      'default_skin' => 3265,
      'game_types' => array (
        0 => 'Activity',
        1 => 'Dungeon',
        2 => 'Pve',
        3 => 'Wvw',
      ),
      'flags' => array (
        0 => 'NoSell',
        1 => 'SoulbindOnAcquire',
        2 => 'SoulBindOnUse',
      ),
      'restrictions' => array ( ),
      'id' => 1,
      'icon' => 'https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png',
      'details' => array (
        'type' => 'Staff',
        'damage_type' => 'Physical',
        'min_power' => 146,
        'max_power' => 165,
        'defense' => 0,
        'infusion_slots' => array ( ),
        'infix_upgrade' => array (
          'attributes' => array ( ),
        ),
        'secondary_suffix_item_id' => '', 
      ),
    );
    $item = Item::createFromArray($attributes);
    $this->assertNotEmpty($item);
    $this->assertEquals(1,$item->getId());
    $this->assertEquals('MONSTER ONLY Moa Unarmed Pet', $item->getName());
    $this->assertEquals('https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png', $item->getIcon());
  }
}
?>