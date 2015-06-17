<?php

use GW2Exchange\Database\Listing;

use GW2Exchange\Listing\ListingAssembler;
use GW2Exchange\Listing\ListingParser;
use GW2Exchange\Listing\ListingFactory;

use GW2Exchange\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class ListingAssemblerTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->listingParser = new ListingParser();
    $this->listingFactory = $this->getMockBuilder('GW2Exchange\Listing\ListingFactory')
      ->setMethods(array('createFromArray'))
      ->getMock();
  }

  public function testGetIdList()
  {
    $json = "[1,3,5,7,9]"; //this is the return from the endpoint
    $return = array(1,3,5,7,9); //this is what we expect to get

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

    $listingAssembler = new ListingAssembler($webScraper,$this->listingParser,$this->listingFactory);
    $itemIds = $listingAssembler->getIdList();
    $this->assertNotEmpty($itemIds);
    $this->assertEquals($return, $itemIds);
  }

  public function testGetByItemIds(){
    $json = '[{"id": 24, "buys": [{"listings": 1, "unit_price": 110, "quantity": 250 }, { "listings": 1, "unit_price": 109, "quantity": 170 }, {"listings": 1, "unit_price": 108, "quantity": 243 }], "sells": [{"listings": 2, "unit_price": 187, "quantity": 66 }, {"listings": 1, "unit_price": 188, "quantity": 6}, {"listings": 1, "unit_price": 189, "quantity": 221}]}]';//listing for item 24
    $arr =
    array("24"=>
    array(
      array (
      "Id"=>24,
      "Orders"=> 1,
      "UnitPrice"=> 110,
      "Quantity"=> 250,
      "Type"=>"buy"
      ),
      array (
      "Id"=>24,
      "Orders"=> 1,
      "UnitPrice"=> 109,
      "Quantity"=> 170,
      "Type"=>"buy"
      ),
      array (
      "Id"=>24,
      "Orders"=> 1,
      "UnitPrice"=> 108,
      "Quantity"=> 243,
      "Type"=>"buy"
      ),
      array (
      "Id"=>24,
      "Orders"=> 2,
      "UnitPrice"=> 187,
      "Quantity"=> 66,
      "Type"=>"sell"
      ),
      array (
      "Id"=>24,
      "Orders"=> 1,
      "UnitPrice"=> 188,
      "Quantity"=> 6,
      "Type"=>"sell"
      ),
      array (
      "Id"=>24,
      "Orders"=> 1,
      "UnitPrice"=> 189,
      "Quantity"=> 221,
      "Type"=>"sell"
      )
    )
    );

    $listing = $this->getMockBuilder('GW2Exchange\Database\Listing')
      ->setMethods(array('isNew','save'))
      ->getMock();
    $listing->method('isNew')
      ->will($this->returnValue(true));
    $listing->method('save')
      ->will($this->returnValue(null));
    $this->listingFactory->method('createFromArray')
      ->will($this->returnValue($listing));

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

    $listingAssembler = new ListingAssembler($webScraper,$this->listingParser,$this->listingFactory);
    $listings = $listingAssembler->getByItemIds(24);
    $this->assertNotEmpty($listings);
    $this->assertEquals(1, count($listings));//we only looked for a single id
    $listing = reset($listings);
    $this->assertEquals(6,count($listing));
    $this->assertTrue($listing[0] instanceof Listing);
  }
}