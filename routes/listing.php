<?php

use \Slim\Slim;

$app = Slim::getInstance(); //just do load it again so that we dont need to worry about using the wrong name

$app->get('/listing',function() use ($app){
  //the list of listings
  $items = $app->config('Listing')->getIdList();
  echo json_encode($items);
});

$app->get('/listing/:itemIds',function($itemIds) use ($app){
  //the list of listings
  $itemIdArr = explode(',',$itemIds);
  $listings = $app->config('Listing')->getByItemIds($itemIdArr);
  $json = array();
  foreach ($listings as $itemId => $itemListings) {
    $temp = array();
    foreach ($itemListings as $key => $listing) {
      $temp[] = $listing->toArray();
    }
    $json[$itemId] = $temp;
  }
  echo json_encode($json);
});
/* Not Implemented for Listings
$app->get('/listing/:itemId/create',function($itemId) use ($app){
  //show a create page
  echo json_encode($listings);
});
*/
$app->post('/listing/:itemId/create',function($itemId) use ($app){
  //create an listing using the data passed
  $listingData = array();
  //we could just pass the entire request variable rather than picking out the pieces
  //but i'd rather know exactly what is coming in
  $listingData['ItemId'] = $app->request->params('ItemId');
  $listingData['Type'] = $app->request->params('Type');
  $listingData['UnitPrice'] = $app->request->params('UnitPrice');
  $listing = $app->config('listing')->createFromArray($listingData);
  echo json_encode($listing);
});

$app->get('/listing/:itemId/:id',function($itemId, $id) use ($app){
  //get the listing with the given id
  echo json_encode($listings);
});
/* Not Implemented for Listings
$app->get('/listing/:itemId/:id/edit',function($itemId, $id) use ($app){
  //show an edit page
  echo json_encode($listings);
});
*/
$app->post('/listing/:itemId/:id/edit',function($itemId, $id) use ($app){
  //update an listing with the data  
  $listingData = array();
  //we could just pass the entire request variable rather than picking out the pieces
  //but i'd rather know exactly what is coming in
  $listingData['ItemId'] = $app->request->params('ItemId');
  $listingData['Type'] = $app->request->params('Type');
  $listingData['UnitPrice'] = $app->request->params('UnitPrice');
  $listing = $app->config('listing')->createFromArray($listingData);
  echo json_encode($listing);
});

$app->post('/listing/:itemId/:id/delete',function($itemId, $id) use ($app){
  //destroy the given listing
  echo json_encode($listings);
});

$app->get('/maintenance/listing',function() use($app){
  $toDo = $app->config('ListingMaintenance')->runMaintenance();
  if($toDo>0){
    echo "<script>window.location.reload();</script>";
  }
});

use GW2Exchange\Database\ItemQueryFactory;
use Propel\Runtime\ActiveQuery\Criteria;
$app->get('/spidy',function() use($app){

    //get all of the items that we know about
    $itemQueryFactory = new ItemQueryFactory();
    //this is all of the items in the database that do not have a price set
    $itemIds = $itemQueryFactory->createQuery()->usePriceQuery(NULL,Criteria::LEFT_JOIN)->filterByItemId(null,Criteria::ISNULL)->endUse()->select('id')->find()->toArray();
    $pageNum = 1;
    $lastPage = 1;
    foreach ($itemIds as $itemId) {
      while(!($pageNum > $lastPage)){
        //if we are not past the last page
        //foreach item look it up in spidy
        $spidyBase = "http://www.gw2spidy.com/api/v0.9/json/listings/";
        $buyUrl = $spidyBase.$itemId.'/buy/'.$pageNum;
        $info = $app->config('WebScraper')->getInfo($buyUrl);
        $listingInfo = json_decode($info,true);
        //for now turn off last page bc we are just getting most current
        //$lastPage = intval($listingInfo['last_page']); //find the last page number
        $buyResults = $listingInfo['results'];


        $spidyBase = "http://www.gw2spidy.com/api/v0.9/json/listings/";
        $buyUrl = $spidyBase.$itemId.'/sell/'.$pageNum;
        $info = $app->config('WebScraper')->getInfo($buyUrl);
        $listingInfo = json_decode($info,true);
        $lastPage = intval($listingInfo['last_page']); //find the last page number
        $sellResults = $listingInfo['results'];
        //for($i=0, $count=count($buyResults); $i<$count; $i++){
        //because prices only records a single price for each item, only do this once
        $i = 0;
          $buyResult = $buyResults[$i];
          $sellResult = $sellResults[$i];
          $buyDate = date('Y-m-d',strtotime($buyResult['listing_datetime']));
          $sellDate = date('Y-m-d',strtotime($sellResult['listing_datetime']));
          if(false && $buyDate != $sellDate){
            //if the two dates don't match
            //create an alert
            d($itemId);
            d($buyResults);
            dd($sellResults);
          }
          $priceTrans = array("ItemId"=>$itemId, "BuyPrice"=> $buyResult['unit_price'], "SellPrice"=> $sellResult['unit_price'], "BuyQty"=> $buyResult['quantity'], "SellQty"=>$sellResult['quantity'], "CreatedAt"=>$sellResult['listing_datetime']);
          $price = $app->config('Price')->createFromArray($priceTrans);
          $price->save();
        //}
        $pageNum++;//move to the next page
      }
      $pageNum = 1;
    }
});