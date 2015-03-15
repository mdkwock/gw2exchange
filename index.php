<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2ledger\Connection\GuzzleWebScraper,
  GuzzleHttp\Client;

use GW2ledger\Listing\ListingAssembler,
  GW2ledger\Database\Listing;

use GW2ledger\Price\PriceAssembler,
  GW2ledger\Database\Price;

//'https://api.guildwars2.com/v2/commerce/price/24';

$client = new Client();
$webScraper = new GuzzleWebScraper($client);

$priceAssembler = new PriceAssembler($webScraper);
$results = $priceAssembler->getByItemId('24');
$results->save();
var_dump($results);
var_dump($results->getBuyPrice());