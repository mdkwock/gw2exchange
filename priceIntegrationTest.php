<?php
$timeFirst = microtime(true);
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2ledger\Connection\GuzzleWebScraper,
  GuzzleHttp\Client;

use GW2ledger\Item\ItemAssembler,
  GW2ledger\Database\Item;

use GW2ledger\Listing\ListingAssembler,
  GW2ledger\Database\Listing;

use GW2ledger\Price\PriceAssembler,
  GW2ledger\Database\Price;

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