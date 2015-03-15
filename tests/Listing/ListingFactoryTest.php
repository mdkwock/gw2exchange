<?php

use GW2ledger\Listing\ListingFactory;
use GW2ledger\Database\Listing;
use GW2ledger\Signature\Database\DatabaseObjectInterface;

use GW2ledger\Connection\GuzzleWebScraper;
use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class ListingFactoryTest extends PHPUnit_Framework_TestCase
{
  public function testCreateFromArray(){
    //make sure only one listing gets created
    $arr = array(
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
    );

    $listingParser = $this->getMockBuilder('\GW2ledger\Listing\ListingParser')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('parseJson'))
                    ->getMock();

    $listingFactory = new ListingFactory($listingParser);
    $listing = $listingFactory->createFromArray($arr);
    $this->assertTrue($listing instanceof DatabaseObjectInterface);
  }
  public function testCreateFromJson(){
    //make sure only one listing gets creative
    $json = '{"id": 24, "buys": [{"listings": 1, "unit_price": 110, "quantity": 250 }, { "listings": 1, "unit_price": 109, "quantity": 170 }, {"listings": 1, "unit_price": 108, "quantity": 243 }], "sells": [{"listings": 2, "unit_price": 187, "quantity": 66 }, {"listings": 1, "unit_price": 188, "quantity": 6}, {"listings": 1, "unit_price": 189, "quantity": 221}]}';//listing for item 24
    $arr = array(
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
    );

    $listingParser = $this->getMockBuilder('\GW2ledger\Listing\ListingParser')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('parseJson'))
                    ->getMock();

    $listingParser->method('parseJson')
        ->will($this->returnValue($arr));


    $listingParser
        ->expects($this->once())
        ->method('parseJson')
        ->with($this->equalTo($json));

    $listingFactory = new ListingFactory($listingParser);
    $listing = $listingFactory->createFromJson($json);
    $this->assertTrue($listing instanceof DatabaseObjectInterface);
  }

  public function testCreateManyFromArray(){
    $arr = array(
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
    );

    $listingParser = $this->getMockBuilder('\GW2ledger\Listing\ListingParser')
                    ->getMock();

    $listingFactory = new ListingFactory($listingParser);
    $listings = $listingFactory->createManyFromArray($arr);
    $this->assertEquals(count($arr),count($listings));
    $this->assertTrue($listings[0] instanceof DatabaseObjectInterface);
  }

  public function testCreateManyFromJson(){
    $json = '{"id": 24, "buys": [{"listings": 1, "unit_price": 110, "quantity": 250 }, { "listings": 1, "unit_price": 109, "quantity": 170 }, {"listings": 1, "unit_price": 108, "quantity": 243 }], "sells": [{"listings": 2, "unit_price": 187, "quantity": 66 }, {"listings": 1, "unit_price": 188, "quantity": 6}, {"listings": 1, "unit_price": 189, "quantity": 221}]}';//listing for item 24
    $arr = array(
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
    );

    $listingParser = $this->getMockBuilder('\GW2ledger\Listing\ListingParser')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('parseJson'))
                    ->getMock();
                    
    $listingParser->expects($this->once())
        ->method('parseJson')
        ->with($this->equalTo($json))
        ->will($this->returnValue($arr));

    $listingFactory = new ListingFactory($listingParser);
    $listings = $listingFactory->createManyFromJson($json);
    $this->assertEquals(count($arr),count($listings));
    $this->assertTrue($listings[0] instanceof DatabaseObjectInterface);
  }
}