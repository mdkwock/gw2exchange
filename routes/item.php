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
  foreach($items as $id=>$item){
    $returns[$id] = $item->toArray();
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
  if(!empty($itemName)){
    //look for partials
    $filters['name'] = '%'.$itemName.'%';
  }

  $itemType = $request->get('type');
  if(!empty($itemType)){
    $filters['type'] = $itemType;
  }

  $itemSubtype = $request->get('subtype');
  if(!empty($itemSubtype)){
    $filters['subtype'] = $itemSubtype;
  }

  $itemRarity = $request->get('rarity');
  if(!empty($itemRarity))
  {
    $filters['rarity'] = $itemRarity;
  }  

  $itemLevel = $request->get('minLevel');
  if(!empty($itemLevel)){
    $filters['minLevel'] = $itemLevel;
  }

  $itemLevel = $request->get('maxLevel');
  if(!empty($itemLevel)){
    $filters['maxLevel'] = $itemLevel;
  }
  $page = $request->get('p');
  $page = empty($page)?1:intval($page);
  $maxPerPage = $request->get('s');
  $maxPerPage = empty($maxPerPage)?10:intval($maxPerPage);
  $results = $app->config('ItemStorage')->search($filters, $page, $maxPerPage);
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
  $staleTime = new DateTime();
  $staleTime->modify('-1 day');
  $toDo = $app->config('ItemMaintenance')->runMaintenance();
  if($toDo>0){
    //count the number of redirects to eliminate too many redirects break
    $_SESSION['redirects'] = empty($_SESSION['redirects'])?1:$_SESSION['redirects']+1;
    if($_SESSION['redirects'] >= 10){
      echo "<script>window.location.reload();</script>";
    }else{
      $app->response->redirect('/GW2Exchange/maintenance/item', 303);
    }
  }
});

$app->get('/maintenance/price',function() use($app){
  $staleTime = new DateTime();
  $staleTime->modify('-1 day');
  $toDo = $app->config('PriceMaintenance')->runMaintenance(null,$staleTime);
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