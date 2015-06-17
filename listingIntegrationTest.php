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

//'https://api.guildwars2.com/v2/commerce/listings';

$client = new Client();
$webScraper = new GuzzleWebScraper($client);

$listingAssembler = new ListingAssembler($webScraper);
$listingIds = $listingAssembler->getIdList();
$i = 0;
$requests = array_chunk($listingIds, 10);
foreach($requests as $request)
{
  $time_start = microtime(true);

  $itemListings = $listingAssembler->getByItemIds($request);
  foreach($itemListings as $itemList){
    foreach($itemList as $listing){
      $listing->save();      
    }
  }
  $time_end = microtime(true);
}
dd(microtime(true)-$timeFirst);