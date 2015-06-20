<?php

use \Slim\Slim;

$app = Slim::getInstance(); //just do load it again so that we dont need to worry about using the wrong name

$app->get('/metadata/types',function() use ($app){
  //the list of listings
  $types = $app->config('Metadata')->getTypes();
  $returns = array();
  //need to filter out so we only get the types
  foreach($types as $type){
    $returns[] = $type['item_type'];
  }
  echo json_encode($returns);
});

$app->get('/metadata/rarities',function() use ($app){
  //the list of listings
  $raritys = $app->config('Metadata')->getRarities();
  $returns = array();
  //need to filter out so we only get the raritys
  foreach($raritys as $rarity){
    $returns[] = $rarity['rarity'];
  }
  echo json_encode($returns);
});

$app->get('/metadata/subtypes',function() use ($app){
  //the list of listings
  $subtypes = $app->config('Metadata')->getSubtypes();
  $returns = array();
  //need to filter out so we only get the subtypes
  foreach($subtypes as $subtype){
    $returns[] = $subtype['value'];
  }
  echo json_encode($returns);
});