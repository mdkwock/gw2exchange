<?php
$timeFirst = microtime(true);
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2Exchange\Connection\GuzzleWebScraper,
  GuzzleHttp\Client;

use GW2Exchange\Item\ItemAssembler,
  GW2Exchange\Database\Item;

use GW2Exchange\Listing\ListingAssembler,
  GW2Exchange\Database\Listing;

use GW2Exchange\Price\PriceAssembler,
  GW2Exchange\Database\Price;

//'https://api.guildwars2.com/v2/commerce/prices';

$client = new Client();
$webScraper = new GuzzleWebScraper($client);

$priceAssembler = new PriceAssembler($webScraper);
$priceIds = $priceAssembler->getIdList();
$i = 0;
$requests = array_chunk($priceIds, 200);
foreach($requests as $request)
{
  $time_start = microtime(true);

  $itemPrices = $priceAssembler->getByItemIds($request);
  foreach($itemPrices as $price){
    $price->save();      
  }
  $time_end = microtime(true);
}
dd(microtime(true)-$timeFirst);