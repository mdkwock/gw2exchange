<?php

use GW2ledger\Price\PriceAssembler;
use GW2ledger\Database\Price;

use GW2ledger\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class PriceAssemblerTest extends PHPUnit_Framework_TestCase
{
  public function testGetByItemId(){    
    $json = '{"id":24,"buys":{"quantity":18719,"unit_price":114},"sells":{"quantity":20115,"unit_price":189}}';//price for item 24
    $object = array(
      "ItemId"=>24,
      "BuyQty"=>18719,
      "BuyPrice"=>114,
      "SellQty"=>20115,
      "SellPrice"=>189
    );
    $response = $this->getMockBuilder('GuzzleHttp\Message\AbstractMessage')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('getBody'))
                    ->getMock();
    $response->method('getBody')
        ->will($this->returnValue($json));

    $client = $this->getMockBuilder('GuzzleHttp\Client')
                     ->setMethods(array('get'))
                     ->getMock();
    $client->method('get')
        ->will($this->returnValue($response));

    $webScraper = new GuzzleWebScraper($client);

    $priceAssembler = new PriceAssembler($webScraper);
    $price = $priceAssembler->getByItemId(1);    
    $this->assertNotEmpty($price);
    $this->assertTrue($price instanceof Price);
    $this->assertEquals($object['BuyQty'], $price->getBuyQty());
  }
}