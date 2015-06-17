<?php

use GW2ledger\Price\PriceFactory;
use GW2ledger\Database\Price;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

use GW2ledger\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class PriceFactoryTest extends PHPUnit_Framework_TestCase
{
  public function testCreateFromArray(){
    //make sure only one price gets created
    $object = array(
      "ItemId"=>24,
      "BuyQty"=>18719,
      "BuyPrice"=>114,
      "SellQty"=>20115,
      "SellPrice"=>189
    );

    $priceParser = $this->getMockBuilder('\GW2ledger\Price\PriceParser')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('parseJson'))
                    ->getMock();

    $priceFactory = new PriceFactory($priceParser);
    $price = $priceFactory->createFromArray($object);
    $this->assertTrue($price instanceof DatabaseObjectInterface);
  }
  public function testCreateFromJson(){
    //make sure only one price gets creative
    
    $json = '[{"id":24,"buys":{"quantity":18719,"unit_price":114},"sells":{"quantity":20115,"unit_price":189}}]';//price for item 24
    $object = array(
      "24"=>array(
        "ItemId"=>24,
        "BuyQty"=>18719,
        "BuyPrice"=>114,
        "SellQty"=>20115,
        "SellPrice"=>189
      )
    );

    $priceParser = $this->getMockBuilder('\GW2ledger\Price\PriceParser')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('parseJson'))
                    ->getMock();

    $priceParser->method('parseJson')
        ->will($this->returnValue($object));


    $priceParser
        ->expects($this->once())
        ->method('parseJson')
        ->with($this->equalTo($json));

    $priceFactory = new PriceFactory($priceParser);
    $prices = $priceFactory->createFromJson($json);
    $price = $prices[24];
    $this->assertTrue($price instanceof DatabaseObjectInterface);
  }
}