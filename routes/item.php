<?php

use \Slim\Slim;
$app = Slim::getInstance(); //just do load it again so that we dont need to worry about using the wrong name

$app->get('/item',function() use ($app){
  //the list of items
  $items = $app->config('Item')->getIdList();
  echo(json_encode($items));
});
/* Not Implemented for Items
$app->get('/item/create',function() use ($app){
  //show a create page
  echo json_encode($items);
});

$app->post('/item',function() use ($app){
  //create an item using the data passed
  echo json_encode($items);
});
*/
$app->get('/item/:ids',function($ids) use ($app){
  //get the item with the given id
  $idArr = explode(',',$ids);
  $items = $app->config('Item')->getByIds($idArr);
  $returns = array();
  $log = $app->config('log');
  foreach($items as $id=>$item){
    $returns[$id] = $item->toArray();
    /*
    <column name="id" type="integer" primaryKey="true" autoIncrement="true" />
    <column name="url" type="integer" required="required" />
    <column name="gw2ServerUrl" type="integer" required="required" />
    <column name="item_id" type="integer" required="required" />
    <column name="cache_hit" type="integer" required="required" />
    $log->
    */
  }
  echo(json_encode($returns));
});
/* Not Implemented for Items
$app->get('/item/:id/edit',function() use ($app){
  //show an edit page
  echo json_encode($items);
});

$app->match('/item/:id',function() use ($app){
  //update an item with the data
  echo json_encode($items);
})->via('PUT','PATCH');

$app->delete('/item/:id',function() use ($app){
  //destroy the given item
  echo json_encode($items);
});
*/
$app->get('/search/item', function() use ($app){
  $request = $app->request;
  $filters = array();
  $itemName = $request->get('name');
  if(isset($name) && (!empty($itemName) || $name===0)){
    //we include 0 as a valid search filter
    //look for partials
    $filters['name'] = '%'.$itemName.'%';
  }

  $itemType = $request->get('type');
  if(isset($type) && (!empty($itemType) || $type===0)){
    //we include 0 as a valid search filter
    $filters['type'] = $itemType;
  }

  $itemSubtype = $request->get('subtype');
  if(isset($subtype) && (!empty($itemSubtype) || $subtype===0)){
    //we include 0 as a valid search filter
    $filters['subtype'] = $itemSubtype;
  }

  $itemRarity = $request->get('rarity');
  if(isset($rarity) && (!empty($itemRarity || $rarity===0)))
    //we include 0 as a valid search filter
  {
    $filters['rarity'] = $itemRarity;
  }  

  $itemLevel = $request->get('minLevel');
  if(isset($minLevel) && (!empty($itemLevel) || $minLevel===0)){
    //we include 0 as a valid search filter
    $filters['minLevel'] = $itemLevel;
  }

  $itemLevel = $request->get('maxLevel');
  if(isset($maxLevel) && (!empty($itemLevel) || $maxLevel===0)){
    //we include 0 as a valid search filter
    $filters['maxLevel'] = $itemLevel;
  }
  
  $itemBuy = $request->get('minBuy');
  if(isset($minBuy) && (!empty($itemBuy) || $minBuy===0)){
    //we include 0 as a valid search filter
    $filters['minBuy'] = $itemBuy;
  }

  $itemBuy = $request->get('maxBuy');
  if(isset($maxBuy) && (!empty($itemBuy) || $maxBuy===0)){
    //we include 0 as a valid search filter
    $filters['maxBuy'] = $itemBuy;
  }
  
  $itemSell = $request->get('minSell');
  if(isset($minSell) && (!empty($itemSell) || $minSell===0)){
    //we include 0 as a valid search filter
    $filters['minSell'] = $itemSell;
  }

  $itemSell = $request->get('maxSell');
  if(isset($maxSell) && (!empty($itemSell) || $maxSell===0)){
    //we include 0 as a valid search filter
    $filters['maxSell'] = $itemSell;
  }
  
  $itemProfit = $request->get('minProfit');
  if(isset($minProfit) && (!empty($itemProfit) || $minProfit===0)){
    //we include 0 as a valid search filter
    $filters['minProfit'] = $itemProfit;
  }

  $itemProfit = $request->get('maxProfit');
  if(isset($maxProfit) && (!empty($itemProfit) || $maxProfit===0)){
    //we include 0 as a valid search filter
    $filters['maxProfit'] = $itemProfit;
  }
  
  $itemROI = $request->get('minROI');
  if(isset($minROI) && (!empty($itemROI) || $minROI===0)){
    //we include 0 as a valid search filter
    $filters['minROI'] = $itemROI;
  }

  $itemROI = $request->get('maxROI');
  if(isset($maxROI) && (!empty($itemROI) || $maxROI===0)){
    //we include 0 as a valid search filter
    $filters['maxROI'] = $itemROI;
  }
  
  $itemSupply = $request->get('minSupply');
  if(isset($minSupply) && (!empty($itemSupply) || $minSupply===0)){
    //we include 0 as a valid search filter
    $filters['minSupply'] = $itemSupply;
  }

  $itemSupply = $request->get('maxSupply');
  if(isset($maxSupply) && (!empty($itemSupply) || $maxSupply===0)){
    //we include 0 as a valid search filter
    $filters['maxSupply'] = $itemSupply;
  }
  
  $itemDemand = $request->get('minDemand');
  if(isset($minDemand) && (!empty($itemDemand) || $minDemand===0)){
    //we include 0 as a valid search filter
    $filters['minDemand'] = $itemDemand;
  }

  $itemDemand = $request->get('maxDemand');
  if(isset($maxDemand) && (!empty($itemDemand) || $maxDemand===0)){
    //we include 0 as a valid search filter
    $filters['maxDemand'] = $itemDemand;
  }
  $page = $request->get('p');
  $page = empty($page)?1:intval($page);
  $maxPerPage = $request->get('s');
  $maxPerPage = empty($maxPerPage)?10:intval($maxPerPage);
  $order = $request->get('order');
  $order = empty($order)?'name':$order;
  $direction = $request->get('dir');
  $direction = empty($direction)?'asc':$direction;
  $results = $app->config('ItemSearch')->searchItems($filters, $order, $direction, $page, $maxPerPage);
  $returns = array();
  foreach($results as $id=>$price){
    if(method_exists($price,'toArray')){
      $returns[$id] = $price->toArray();
    }else{
      $returns[$id] = $price;
    }
  }
  echo(json_encode($returns));
});

$app->get('/item/search/suggest(/:itemName)', function($itemName = "") use ($app){
  if(empty($itemName)){
    //favor using the parameters over the request variables, for possible seo reasons
    //may change if decide that they are going to send options, with the chance to rename
    $itemName = $app->request->params('itemName');
  }

  if(empty($itemName)){
    //if they arent searching anything in particular just send the most +____
  }else{
    $returns = $app->config('ItemStorage')->suggestName($itemName);
    echo(json_encode($returns));
  }
});

/******************* START Price Lookups *************************/
$app->get('/item/:ids/price',function($ids) use ($app){
  //get the item with the given id
  $itemIdArr = explode(',',$ids);
  $prices = $app->config('PriceStorage')->getByItemIds($itemIdArr);
  $returns = array();
  foreach($prices as $id=>$price){
    $price->save();
    $returns[$id] = $price->toArray();
  }
  echo(json_encode($returns));
});

$app->get('/item/:ids/price/history',function($ids) use ($app){
  //get the item with the given ids
  $prices = $app->config('PriceStorage')->getPriceHistory($ids);
  $returns = array();
  foreach($prices as $price){
    $returns[] = $price->toArray();
  }
  echo(json_encode($returns));
});

$app->get('/item/:id/price/update',function($id) use ($app){
  //update the item's price
  //setAll($item_id, $buy_price, $sell_price, $buy_qty, $sell_qty, $created_at=null)
  $buyPrice = $app->request->params('buyPrice');
  $sellPrice = $app->request->params('sellPrice');
  $buyQty = $app->request->params('buyQty');
  $sellQty = $app->request->params('sellQty');

  $attrs = array(
    'ItemId'=>$id,
    'BuyPrice'=>$buyPrice,
    'SellPrice'=>$sellPrice,
    'BuyQty'=>$buyQty,
    'SellQty'=>$sellQty
  );
  $price = $app->config('Price')->createFromArray($attrs);
  //dd($price);
  $price->save();
});
/******************* END Price Lookups *************************/

$app->get('/maintenance/item',function() use($app){
  $toDo = $app->config('ItemMaintenance')->runMaintenance();
  if($toDo>0){
    //count the number of redirects to eliminate too many redirects break
    $_SESSION['redirects'] = empty($_SESSION['redirects'])?1:$_SESSION['redirects']+1;
    if($_SESSION['redirects'] >= 10){
      $_SESSION['redirects'] = 0;
      echo "<script>window.location.reload();</script>";
    }else{
      $app->response->redirect('/GW2Exchange/maintenance/item', 303);
    }
  }
});

$app->get('/maintenance/price',function() use($app){
  $toDo = $app->config('PriceMaintenance')->runMaintenance();
  if($toDo>0){
    //count the number of redirects to eliminate too many redirects break
    $_SESSION['redirects'] = empty($_SESSION['redirects'])?1:$_SESSION['redirects']+1;
    if($_SESSION['redirects'] >= 10){
      $_SESSION['redirects'] = 0;
      echo "<script>window.location.reload();</script>";
    }else{
      $app->response->redirect('/GW2Exchange/maintenance/price', 303);
    }
  }
});