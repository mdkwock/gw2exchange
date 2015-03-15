<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2ledger\Connection\GuzzleWebScraper,
  GW2ledger\Item\ItemParser,
  GW2ledger\Item\ItemFactory,
  GW2ledger\Item\ItemInfoFactory,
  GW2ledger\Item\ItemDetailsArrayObjectFactory,
  GuzzleHttp\Client;

use GW2ledger\Database\Map\ItemInfoTableMap;
use GW2ledger\Database\ItemInfo;
$itemInfo = new ItemInfo();