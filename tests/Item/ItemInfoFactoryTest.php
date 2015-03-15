 <?php

use GW2ledger\Item\ItemParser;
use GW2ledger\Database\ItemInfo;
use GW2ledger\Item\ItemInfoFactory;
use GW2ledger\Signature\Database\DatabaseObjectInterface;


class ItemInfoFactoryTest extends PHPUnit_Framework_TestCase
{

  public function testCreateFromJson()
  {
    $json = '{"name":"MONSTER ONLY Moa Unarmed Pet","type":"Weapon","level":0,"rarity":"Fine","vendor_value":0,"default_skin":3265,"game_types":["Activity","Dungeon","Pve","Wvw"],"flags":["NoSell","SoulbindOnAcquire","SoulBindOnUse"],"restrictions":[],"id":1,"icon":"https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png","details":{"type":"Staff","damage_type":"Physical","min_power":146,"max_power":165,"defense":0,"infusion_slots":[],"infix_upgrade":{"attributes":[]},"secondary_suffix_item_id":""}}';//the first item
    $itemParser = new ItemParser();
    $itemInfoFactory = new ItemInfoFactory($itemParser);
    $itemInfo = $itemInfoFactory->createFromJson($json);
    $this->assertNotEmpty($itemInfo);
    $this->assertTrue($itemInfo instanceof DatabaseObjectInterface);
    $this->assertEquals(1,$itemInfo->getItemId());
    $this->assertNull($itemInfo->getDescription());
    $this->assertEquals('Weapon',$itemInfo->getType());
    $this->assertEquals('Fine',$itemInfo->getRarity());
    $this->assertEquals(0,$itemInfo->getLevel());
    $this->assertEquals(0,$itemInfo->getVendorValue());
    $this->assertEquals(3265,$itemInfo->getDefaultSkin());
    $this->assertEquals(array("NoSell","SoulbindOnAcquire","SoulBindOnUse"),$itemInfo->getFlags());    
    $this->assertEquals(array("Activity","Dungeon","Pve","Wvw"),$itemInfo->getGameTypes());
    $this->assertEquals(array(),$itemInfo->getRestrictions());
  }
}
?>