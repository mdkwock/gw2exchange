<?php
require_once __DIR__ . '/vendor/autoload.php';
use \PHPQueue\Runner;
require './database/generated-conf/config.php';
require_once __DIR__ . '/queue-config.php';

use Raveren\Kint;
use GW2Exchange\Connection\GuzzleWebScraper,
  GuzzleHttp\Client;

use GW2Exchange\Item\ItemAssembler,
  GW2Exchange\Item\ItemParser,
  GW2Exchange\Item\BaseItemFactory,
  GW2Exchange\Item\ItemInfoFactory,
  GW2Exchange\Item\ItemDetailFactory,
  GW2Exchange\Item\ItemItemDetailFactory,
  GW2Exchange\Item\ItemDetailsArrayObjectFactory,
  GW2Exchange\Item\ItemFactory,
  GW2Exchange\Database\Item;

use GW2Exchange\Queue\SampleQueue;
use GW2Exchange\Runner\GW2Runner;
use PHPQueue\Base;

use GW2Exchange\Price\PriceAssembler,
  GW2Exchange\Price\PriceParser,
  GW2Exchange\Price\PriceFactory,
  GW2Exchange\Database\Price;


$client = new Client();
$webScraper = new GuzzleWebScraper($client);
$itemParser = new ItemParser();

$itemDetailFactory = new ItemDetailFactory();
$itemItemDetailFactory = new ItemItemDetailFactory();
$itemDetailsArrayObjectFactory = new ItemDetailsArrayObjectFactory($itemDetailFactory, $itemItemDetailFactory);

$baseItemFactory = new BaseItemFactory();
$itemInfoFactory = new ItemInfoFactory();

$itemFactory = new ItemFactory($baseItemFactory, $itemInfoFactory, $itemDetailsArrayObjectFactory);

$itemAssembler = new ItemAssembler($webScraper, $itemParser, $itemFactory);

$priceParser = new PriceParser();
$priceFactory = new PriceFactory();
$priceAssembler = new PriceAssembler($webScraper, $priceParser, $priceFactory);

$queueName = 'SampleQueue';
$queue = Base::getQueue($queueName);
$queue->setWorkerName('GW2ServerWorker');
$queue->addJob(array('taskType' => 'item', 'ids'=>array(2,3,4,5,21)));
$queue->addJob(array('taskType' => 'price', 'ids'=>array(3,36,24,53,221)));
$queue->addJob(array('taskType' => 'price', 'ids'=>array(27,31,234,5365,21)));


$runner = new GW2Runner($queueName,array('logPath'=>__DIR__,'ItemAssembler'=>$itemAssembler, 'PriceAssembler'=>$priceAssembler));

$runner->run();