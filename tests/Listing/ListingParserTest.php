<?php

use GW2ledger\Listing\ListingParser;


class ListingParserTest extends PHPUnit_Framework_TestCase
{
  public function testParseJson()
  {
  $json = '{
    "id": 24,
    "buys": [{
      "listings": 1,
      "unit_price": 110,
      "quantity": 250
    }, {
      "listings": 1,
      "unit_price": 109,
      "quantity": 170
    }, {
      "listings": 1,
      "unit_price": 108,
      "quantity": 243
    }],
    "sells": [{
      "listings": 2,
      "unit_price": 187,
      "quantity": 66
    }, {
      "listings": 1,
      "unit_price": 188,
      "quantity": 6
    }, {
      "listings": 1,
      "unit_price": 189,
      "quantity": 221
    }]
  }';//listing for item 24
  $object = array(
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
  $listingParser = new ListingParser();
  $result = $listingParser->parseJson($json);
  $this->assertNotEmpty($result);
  $this->assertEquals($object,$result);
  }
}
?>