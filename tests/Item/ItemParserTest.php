<?php

use GW2ledger\Item\ItemParser;


class ItemParserTest extends PHPUnit_Framework_TestCase
{
    public function testParseJson()
    {
        $json = '{"name":"MONSTER ONLY Moa Unarmed Pet","type":"Weapon","level":0,"rarity":"Fine","vendor_value":0,"default_skin":3265,"game_types":["Activity","Dungeon","Pve","Wvw"],"flags":["NoSell","SoulbindOnAcquire","SoulBindOnUse"],"restrictions":[],"id":1,"icon":"https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png","details":{"type":"Staff","damage_type":"Physical","min_power":146,"max_power":165,"defense":0,"infusion_slots":[],"infix_upgrade":{"attributes":[]},"secondary_suffix_item_id":""}}';//the first item
        $object = array ( 
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
        $result = ItemParser::parseJson($json);
        $this->assertNotEmpty($result);
        $this->assertEquals($object,$result);
    }
}
?>