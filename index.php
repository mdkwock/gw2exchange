<?php
require_once 'vendor/autoload.php';

session_start();

require __DIR__.'/database/generated-conf/config.php';
use \Slim\Slim;

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

use GW2Exchange\Database\ItemQueryFactory,
  GW2Exchange\Maintenance\ItemMaintenance;

use GW2Exchange\Item\ItemStorage;

use GW2Exchange\Listing\ListingAssembler,
  GW2Exchange\Listing\ListingParser,
  GW2Exchange\Listing\ListingFactory,
  GW2Exchange\Database\Listing;

use GW2Exchange\Database\ListingQueryFactory,
  GW2Exchange\Maintenance\ListingMaintenance;

use GW2Exchange\Price\PriceAssembler,
  GW2Exchange\Log\PriceLogger,
  GW2Exchange\Price\PriceParser,
  GW2Exchange\Price\PriceFactory,
  GW2Exchange\Database\Price;

use GW2Exchange\Price\PriceStorage;

use GW2Exchange\Database\PriceQueryFactory,
  GW2Exchange\Database\PriceHistoryQueryFactory,
  GW2Exchange\Maintenance\PriceMaintenance;

use GW2Exchange\Metadata\SearchMetadata,
  GW2Exchange\Search\ItemSearch;

use PHPQueue\Backend\IronMQ,
  PHPQueue\Base;

$logger = new \Flynsarmy\SlimMonolog\Log\MonologWriter(array(
    'handlers' => array(
        new \Monolog\Handler\StreamHandler('./logs/'.date('Y-m-d').'.log'),
    ),
));

$app = new Slim(array(
    'mode' => 'development',
    'log.writer' => $logger,
    'debug' => true,
));

$app->setName("GW2Rest");

$app->configureMode('development', function () use($app){
  $client = new Client();
  $webScraper = new GuzzleWebScraper($client);
  $itemParser = new ItemParser();

$ironConfig = array(
  'token' => 'bMbG6sQnvhl2OVFRjXeM7Lw7rqQ',
  'project_id' => '55d65d444d246d000a000042',
  'queue_name' => 'gw2-server-poll',
  'msg_options' => array(
      "timeout" => 60
    , "delay"   => 0
    , "expires_in" => 172800
  )
);
require_once __DIR__ . '/queue-config.php';

  $backend = new IronMQ($ironConfig);

  $queueName = 'GW2Queue';
  $queue = Base::getQueue($queueName);
  $queue->setWorkerName('GW2ServerWorker');
  $queue->setDataSource($backend);
 
  $itemDetailFactory = new ItemDetailFactory();
  $itemItemDetailFactory = new ItemItemDetailFactory();
  $itemDetailsArrayObjectFactory = new ItemDetailsArrayObjectFactory($itemDetailFactory, $itemItemDetailFactory);
 
  $baseItemFactory = new BaseItemFactory();
  $itemInfoFactory = new ItemInfoFactory();

  $itemFactory = new ItemFactory($baseItemFactory, $itemInfoFactory, $itemDetailsArrayObjectFactory);

  $itemAssembler = new ItemAssembler($webScraper, $itemParser, $itemFactory);

  $itemQueryFactory = new ItemQueryFactory();

  $itemStorage = new ItemStorage($itemQueryFactory, $itemFactory);
  $itemMaintenance = new ItemMaintenance($itemAssembler, $itemStorage, $itemQueryFactory);


  $listingParser = new ListingParser();
  $listingFactory = new ListingFactory();
  $listingAssembler = new ListingAssembler($webScraper, $listingParser, $listingFactory);

  $listingQueryFactory = new ListingQueryFactory();
  $listingMaintenance = new ListingMaintenance($listingAssembler,$listingQueryFactory, $itemQueryFactory);


  $priceParser = new PriceParser();
  $priceLogger = new PriceLogger();
  $priceFactory = new PriceFactory($priceLogger);
  $priceAssembler = new PriceAssembler($webScraper, $priceParser, $priceFactory);

  $priceQueryFactory = new PriceQueryFactory();
  $PriceHistoryQueryFactory = new PriceHistoryQueryFactory();
  
  $priceStorage = new PriceStorage($priceQueryFactory, $PriceHistoryQueryFactory, $priceFactory, $priceLogger, $priceAssembler);
  $priceMaintenance = new PriceMaintenance($priceAssembler, $priceStorage,$itemStorage);

  $metadata = new SearchMetadata($itemQueryFactory);
  $itemSearch = new ItemSearch($itemQueryFactory, $priceQueryFactory,$itemStorage,$priceStorage,$priceAssembler,$priceLogger);

  //get all the ids to be updated
  $idList = $priceMaintenance->getToDoList(200);
  if(!empty($idList)){
    //add the ids to be updated to the queue
    $queue->addJob(array('taskType' => 'price', 'ids'=>$idList));

    //mark all the items as updated so that we dont check them more than once too quickly
    $priceQueryFactory->createQuery()->filterByPrimaryKeys($idList)->update(array('UpdatedAt'=>date('Y-m-d H:i:s')));
  }
  
  $app->config(array(
    'Item'=>$itemAssembler, 
    'Listing'=>$listingAssembler, 
    'Price'=>$priceAssembler, 
    'ItemMaintenance'=>$itemMaintenance,
    'ListingMaintenance'=>$listingMaintenance,
    'PriceMaintenance'=>$priceMaintenance,
    'WebScraper'=>$webScraper,
    'ItemStorage'=>$itemStorage,
    'PriceStorage'=>$priceStorage,
    'Metadata'=>$metadata,
    'ItemSearch'=>$itemSearch,
    'Queue'=>$queue
  ));
});

$app->response->headers->set('Access-Control-Allow-Origin', '*');

// Dynamically include all files in the routes directory
foreach (new DirectoryIterator(__DIR__."/".'routes') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__."/".'routes'."/".$file->getFilename();
    }
}
//*/
//
$app->run();