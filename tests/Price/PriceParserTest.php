<?php

use GW2Exchange\Price\PriceParser;


class PriceParserTest extends PHPUnit_Framework_TestCase
{
  public function testParseJson()
  {
    $json = '[{"id":24,"buys":{"quantity":18719,"unit_price":114},"sells":{"quantity":20115,"unit_price":189}}]';//listing for item 24
    $object = array(
      "24" => array(
        "ItemId"=>24,
        "BuyQty"=>18719,
        "BuyPrice"=>114,
        "SellQty"=>20115,
        "SellPrice"=>189
      )
    );
    $listingParser = new PriceParser();
    $result = $listingParser->parseJson($json);
    $this->assertNotEmpty($result);
    $this->assertEquals($object,$result);
  }
}
?>