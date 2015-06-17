<?php
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

//'https://api.guildwars2.com/v2/commerce/price/24';

$client = new Client();
$webScraper = new GuzzleWebScraper($client);

$itemAssembler = new ItemAssembler($webScraper);
$itemIds = $itemAssembler->getIdList();
$i = 0;
$requests = array_chunk($itemIds, 200);
foreach($requests as $request)
{
  $time_start = microtime(true);

  $items = $itemAssembler->getByIds($request);
  foreach($items as $item){
    $item->save();
  }
  $time_end = microtime(true);
}