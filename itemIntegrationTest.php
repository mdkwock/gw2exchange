<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2Exchange\Connection\GuzzleWebScraper,
  GuzzleHttp\Client;

use GW2Exchange\Item\ItemAssembler,
GW2Exchange\Item\ItemParser,
GW2Exchange\Item\BaseItemFactory,
GW2Exchange\Item\ItemInfoFactory,
GW2Exchange\Item\ItemDetailFactory,
GW2Exchange\Item\ItemItemDetailFactory,
GW2Exchange\Item\ItemDetailsArrayObjectFactory,
  GW2Exchange\Database\Item;

use GW2Exchange\Listing\ListingAssembler,
  GW2Exchange\Database\Listing;

use GW2Exchange\Price\PriceAssembler,
  GW2Exchange\Database\Price;

//'https://api.guildwars2.com/v2/commerce/price/24';

$client = new Client();
$webScraper = new GuzzleWebScraper($client);

$itemParser = new ItemParser();
//dd(is_a($itemParser, '\GW2Exchange\Signature\Item\ItemParserInterface'));
$baseItemFactory = new BaseItemFactory();
$itemInfoFactory = new ItemInfoFactory();
$itemDetailFactory = new ItemDetailFactory();
$itemItemDetailFactory = new ItemItemDetailFactory();
$itemPiecesFactory = new ItemDetailsArrayObjectFactory($itemDetailFactory, $itemItemDetailFactory);

$itemAssembler = new ItemAssembler($webScraper,$itemParser,$baseItemFactory,$itemInfoFactory,$itemPiecesFactory);
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