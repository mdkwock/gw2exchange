<?php

use GW2ledger\Item\ItemAssembler;
use GW2ledger\Item\Item;

use GW2ledger\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class ItemAssemblerTest extends PHPUnit_Framework_TestCase
{
  public function testGetByIds(){                                
    $answer = '[{"name":"MONSTER ONLY Moa Unarmed Pet","type":"Weapon","level":0,"rarity":"Fine","vendor_value":0,"default_skin":3265,"game_types":["Activity","Dungeon","Pve","Wvw"],"flags":["NoSell","SoulbindOnAcquire","SoulBindOnUse"],"restrictions":[],"id":1,"icon":"https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png","details":{"type":"Staff","damage_type":"Physical","min_power":146,"max_power":165,"defense":0,"infusion_slots":[],"infix_upgrade":{"attributes":[]},"secondary_suffix_item_id":""}}]';//the first item
    $response = $this->getMockBuilder('GuzzleHttp\Message\AbstractMessage')
                    ->setMethods(array('getBody'))
                    ->getMock();
    $response->method('getBody')
        ->will($this->returnValue($answer));

    $client = $this->getMockBuilder('GuzzleHttp\Client')
                     ->setMethods(array('get'))
                     ->getMock();
    $client->method('get')
        ->will($this->returnValue($response));

    $webScraper = new GuzzleWebScraper($client);

    $itemFactory = new ItemAssembler($webScraper);
    $item = $itemFactory->getByIds(1);    
    $this->assertNotEmpty($item);
    $this->assertTrue($item[1] instanceof Item);
  }
}