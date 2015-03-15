<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2ledger\Connection\GuzzleWebScraper,
  GuzzleHttp\Client;

use GW2ledger\Listing\ListingParser,
  GW2ledger\Listing\ListingAssembler,
  GW2ledger\Listing\ListingFactory,
  GW2ledger\Database\Listing;

//'https://api.guildwars2.com/v2/commerce/listings/24';

$client = new Client();
$webScraper = new GuzzleWebScraper($client);

$listingAssembler = new ListingAssembler($webScraper);
$results = $listingAssembler->getByItemId('24');
var_dump($results[0]);
var_dump($results[0]->getUnitPrice());