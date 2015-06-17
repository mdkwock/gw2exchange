<?php

use GW2Exchange\Item\ItemParser;
use GW2Exchange\Item\BaseItemFactory;
use GW2Exchange\Item\ItemInfoFactory;
use GW2Exchange\Item\ItemFactory;
use GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
use GW2Exchange\Signature\Item\ItemFactoryInterface;
use GW2Exchange\Item\ItemAssembler;
use GW2Exchange\Item\Item;
use GW2Exchange\Database\Item as BaseItem;
use GW2Exchange\Database\ItemInfo;
use GW2Exchange\Item\ItemDetailsArrayObject;
use GW2Exchange\Signature\Database\DatabaseObjectInterface;

use GW2Exchange\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class ItemAssemblerTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){
    $this->response = $this->getMockBuilder('GuzzleHttp\Message\AbstractMessage')
      ->setMethods(array('getBody'))
      ->getMock();
    $this->client = $this->getMockBuilder('GuzzleHttp\Client')
      ->setMethods(array('get'))
      ->getMock();
    $this->itemParser = new ItemParser();
    $this->itemFactory = $this->getMockBuilder('GW2Exchange\Signature\Item\ItemFactoryInterface')
      ->setMethods(array('createFromArray'))
      ->disableOriginalConstructor()
      ->getMock();


    $this->baseItemFactory = $this->getMockBuilder('GW2Exchange\Item\BaseItemFactory')
      ->setMethods(array('createFromArray'))
      ->getMock();
    $this->itemInfoFactory = $this->getMockBuilder('GW2Exchange\Item\ItemInfoFactory')
      ->setMethods(array('createFromArray'))
      ->getMock();
    $this->itemDetailsFactory = $this->getMockBuilder('GW2Exchange\Signature\Item\ItemPiecesFactoryInterface')
      ->setMethods(array('createFromArray'))
      ->getMock();


    $this->itemDetailFactory = $this->getMockBuilder('GW2Exchange\Item\ItemDetailFactory')
      ->setMethods(array('create'))
      ->getMock();
    $this->itemItemDetailFactory = $this->getMockBuilder('GW2Exchange\Item\ItemItemDetailFactory')
      ->setMethods(array('create'))
      ->getMock();
  }

  public function testGetIdList(){

    $json = "[1,3,5,7,9]"; //this is the return from the endpoint
    $return = array(1,3,5,7,9); //this is what we expect to get

    $this->response->method('getBody')
      ->will($this->returnValue($json));

    $this->client->method('get')
      ->will($this->returnValue($this->response));


    $webScraper = new GuzzleWebScraper($this->client);


    $itemAssembler = new ItemAssembler($webScraper,$this->itemParser,$this->itemFactory);
    $itemIds = $itemAssembler->getIdList();    
    $this->assertNotEmpty($itemIds);
    $this->assertEquals($return, $itemIds);
  }

  public function testGetByIds(){                                
    $answer = '[{"name":"MONSTER ONLY Moa Unarmed Pet","type":"Weapon","level":0,"rarity":"Fine","vendor_value":0,"default_skin":3265,"game_types":["Activity","Dungeon","Pve","Wvw"],"flags":["NoSell","SoulbindOnAcquire","SoulBindOnUse"],"restrictions":[],"id":1,"icon":"https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png","details":{"type":"Staff","damage_type":"Physical","min_power":146,"max_power":165,"defense":0,"infusion_slots":[],"infix_upgrade":{"attributes":[]},"secondary_suffix_item_id":""}}]';//the first item
    $object = array ( 
      array(
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

    $item = $this->getMockBuilder('GW2Exchange\Item\Item')
      ->disableOriginalConstructor()
      ->getMock();

    $this->itemFactory->expects($this->once())
      ->method('createFromArray')
      ->with($this->equalTo($object[0]))
      ->will($this->returnValue($item));

    $webScraper = new GuzzleWebScraper($client);

    $itemAssembler = new ItemAssembler($webScraper,$this->itemParser,$this->itemFactory);
    $createdItem = $itemAssembler->getByIds(1);    
    $this->assertNotEmpty($item);
    $this->assertEquals($item,$createdItem[0]);
  }
}