<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';

use GW2ledger\Connection\GuzzleWebScraper;
use GW2ledger\Item\ItemParser;
use GW2ledger\Item\ItemFactory;

$scraper = new GuzzleWebScraper();
$webInfo = $scraper->getInfo('https://api.guildwars2.com/v2/items/1');

$itemParser = new ItemParser();
$itemFactory = new ItemFactory($itemParser);

$item = $itemFactory->createFromJson($webInfo);
$item->save();
dd($item);