<?php

use GW2ledger\Database\Item;
use GW2ledger\Item\ItemParser;
use GW2ledger\Signature\Item\ItemDetailsObjectInterface;
use GW2ledger\Item\ItemDetailsArrayObjectFactory;


class ItemDetailsArrayObjectFactoryTest extends PHPUnit_Framework_TestCase
{
  public function testCreateFromJson()
  {
    $attributes =array(
      array ( 
        'Name' => 'MONSTER ONLY Moa Unarmed Pet',
        'Type' => 'Weapon', 
        'Level' => 0,
        'Rarity' => 'Fine',
        'VendorValue' => 0,
        'DefaultSkin' => 3265,
        'GameTypes' => array (
        0 => 'Activity',
        1 => 'Dungeon',
        2 => 'Pve',
        3 => 'Wvw',
        ),
        'Flags' => array (
        0 => 'NoSell',
        1 => 'SoulbindOnAcquire',
        2 => 'SoulBindOnUse',
        ),
        'Restrictions' => array ( ),
        'Id' => 1,
        'Icon' => 'https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png',
        'Details' => array (
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
      )
    );
    $itemParser = new ItemParser();
    $attributes[0]['item_id'] = 1;
    $json = json_encode($attributes);
    $itemFactory = new ItemDetailsArrayObjectFactory($itemParser);
    $itemDetails = $itemFactory->createFromJson($json);
    $this->assertNotEmpty($itemDetails);
    $this->assertTrue(reset($itemDetails) instanceof ItemDetailsObjectInterface);
  }

  public function testCreateFromArray()
  {
    $attributes = array ( 
      'Name' => 'MONSTER ONLY Moa Unarmed Pet',
      'Type' => 'Weapon', 
      'Level' => 0,
      'Rarity' => 'Fine',
      'VendorValue' => 0,
      'DefaultSkin' => 3265,
      'GameTypes' => array (
      0 => 'Activity',
      1 => 'Dungeon',
      2 => 'Pve',
      3 => 'Wvw',
      ),
      'Flags' => array (
      0 => 'NoSell',
      1 => 'SoulbindOnAcquire',
      2 => 'SoulBindOnUse',
      ),
      'Restrictions' => array ( ),
      'Id' => 1,
      'Icon' => 'https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png',
      'Details' => array (
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
    $itemParser = new ItemParser();
    $attributes['item_id'] = 1;
    $itemFactory = new ItemDetailsArrayObjectFactory($itemParser);
    $itemDetails = $itemFactory->createFromArray($attributes);
    $this->assertNotEmpty($itemDetails);
    $this->assertTrue($itemDetails instanceof ItemDetailsObjectInterface);

  }
}