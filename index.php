<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2ledger\Connection\GuzzleWebScraper,
  GW2ledger\Item\ItemParser,
  GW2ledger\Item\ItemFactory,
  GW2ledger\Item\ItemInfoFactory,
  GW2ledger\Item\ItemDetailsArrayObjectFactory,
  GuzzleHttp\Client;

        $url = "https://api.guildwars2.com/v2/items/2";//this has a very simple result
        $itemParser = new ItemParser();
        $itemFactory = new ItemFactory($itemParser);
        $itemInfoFactory = new ItemInfoFactory($itemParser);
        $itemDetailsFactory = new ItemDetailsArrayObjectFactory($itemParser);

        $client = new Client();

        $webScraper = new GuzzleWebScraper($client);
        $result = $webScraper->getInfo($url);
        var_dump($result);
        echo "<br /><br />";
        $item = $itemFactory->createFromJson($result);
        var_dump($item);
        echo "<br /><br />";
        $itemInfo = $itemInfoFactory->createFromJson($result);
        var_dump($itemInfo);
        echo "<br /><br />";
        $itemDetails = $itemDetailsFactory->createFromJson($item,$result);
        var_dump($itemDetails);
        echo "<br /><br />";

        $item->save();
        $itemInfo->save();
        $itemDetails->save();