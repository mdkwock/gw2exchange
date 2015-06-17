<?php

use GW2Exchange\Price\PriceAssembler;
use GW2Exchange\Price\PriceFactory;
use GW2Exchange\Price\PriceParser;
use GW2Exchange\Database\Price;

use GW2Exchange\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class PriceAssemblerTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->response = $this->getMockBuilder('GuzzleHttp\Message\AbstractMessage')
      ->setMethods(array('getBody'))
      ->getMock();
    $this->client = $this->getMockBuilder('GuzzleHttp\Client')
      ->setMethods(array('get'))
      ->getMock();
    $this->priceParser = new PriceParser();
    $this->priceFactory = $this->getMockBuilder('GW2Exchange\Price\PriceFactory')
      ->setMethods(array('createFromArray'))
      ->getMock();
  }

  public function testGetIdList()
  {
    $json = "[1,3,5,7,9]"; //this is the return from the endpoint
    $return = array(1,3,5,7,9); //this is what we expect to get

    $this->response->method('getBody')
      ->will($this->returnValue($json));

    $this->client->method('get')
      ->will($this->returnValue($this->response));


    $webScraper = new GuzzleWebScraper($this->client);


    $priceAssembler = new PriceAssembler($webScraper,$this->priceParser,$this->priceFactory);
    $itemIds = $priceAssembler->getIdList();    
    $this->assertNotEmpty($itemIds);
    $this->assertEquals($return, $itemIds);
  }

  public function testGetByItemId(){    
    $json = '[{"id":24,"buys":{"quantity":18719,"unit_price":114},"sells":{"quantity":20115,"unit_price":189}}]';//price for item 24
    $object = array(
      "ItemId"=>24,
      "BuyQty"=>18719,
      "BuyPrice"=>114,
      "SellQty"=>20115,
      "SellPrice"=>189
    );

    $this->response->method('getBody')
      ->will($this->returnValue($json));

    $this->client->method('get')
      ->will($this->returnValue($this->response));

    $price = $this->getMockBuilder('GW2Exchange\Database\Price')
      ->setMethods(array('isNew','save'))
      ->getMock();
    $price->method('isNew')
      ->will($this->returnValue(true));
    $price->method('save')
      ->will($this->returnValue(null));
    $this->priceFactory->method('createFromArray')
      ->with($this->equalTo($object))
      ->will($this->returnValue($price));

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

    $priceAssembler = new PriceAssembler($webScraper,$this->priceParser,$this->priceFactory);
    $prices = $priceAssembler->getByItemIds(1);
  }
}