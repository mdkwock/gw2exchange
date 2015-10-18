<?php
namespace GW2Exchange\Price;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;

use \GW2Exchange\Signature\Price\PriceParserInterface;
use \GW2Exchange\Signature\Price\PriceFactoryInterface;
use \GW2Exchange\Price\Price;
use \GW2Exchange\Price\PriceAssembler;
use GW2Exchange\Database\PriceQuery;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\PriceTableMap;

use GW2Exchange\Log\PriceLogger;

/**
 * 
 */
class PriceStorage
{
  protected $priceQueryFactory;
  protected $priceHistoryQueryFactory;
  protected $priceFactory;
  protected $priceLogger;
  protected $priceAssembler;
  protected $stmt; //this is a statement object stored for use in the custom query functions

  public function __construct(DatabaseQueryFactoryInterface $pqf,DatabaseQueryFactoryInterface $phqf, PriceFactoryInterface $pf, PriceLogger $pl, PriceAssembler $pa)
  {
    $this->priceQueryFactory = $pqf;
    $this->priceHistoryQueryFactory = $phqf;
    $this->priceFactory = $pf;
    $this->priceLogger = $pl;
    $this->priceAssembler = $pa;
  }

  public function prepareCustomQuery($sql){

    $con = Propel::getWriteConnection(PriceTableMap::DATABASE_NAME);
    $this->stmt = $con->prepare($sql);
  }

  public function fetchAllCustomQuery(){
    $this->stmt->execute();
    $data = $this->stmt->fetchAll();
    return $data;
  }


  /**
   * returns all of the item ids that we track
   * @return int[]   an array of all the item ids
   */
  public function getAllItemIds()
  {
    $priceQuery = $this->priceQueryFactory->createQuery()->select('ItemId');
    $priceIds = $priceQuery->find()->toArray();
    return $priceIds;
  }

  public function getByItemIds($itemIds)
  {

    $priceQuery = $this->priceQueryFactory->createQuery();
    $prices = $priceQuery->findPKs($itemIds);

    if(!empty($prices)){

      //get a set of answers from the gw2 servers to compare with
      $serverResponse = $this->priceAssembler->getByItemIds($itemIds);
      //for this task re-index the server prices by item it so that it is easier to look up
      $serverPrices = array();
      foreach ($serverResponse as $price) {
        $key = $price->getItemId();
        $serverPrices[$key] = $price;
      }
      
      $prices = $prices->getData();


      //create a new log entry  for the lookup
      foreach ($prices as $price) {
        $cacheCorrect = null;
        $priceHistory = $price->getPriceHistories()->pop();//the most recent price history is the same as the current price
        $cacheTime = $price->getCacheTime();
        $lastUpdated = $price->getUpdatedAt();
        if(time() < $lastUpdated->getTimestamp() +($cacheTime*60*1000)){
          //if the time now is before the next cache update time, then the cache is hit
          $cacheHit = true;
          //if it does hit the cache check to see if the cache is correct
          $key = $price->getItemId();
          $testPrice = $serverPrices[$key];
          $testHash = $testPrice->hash();
          $myHash = $price->hash();
          $cacheCorrect = $testHash==$myHash;
        }else{
          //if the cache is expired it does not hit the cache
          $cacheHit = false;
        }
        $this->priceLogger->logPriceRequest($priceHistory,$cacheHit,$cacheCorrect);
        //save the price history because we are not actually saving anything otherwise
        $priceHistory->save();
      }



    }
    return $prices;
  }

  public function getPriceHistory($itemId){
    $priceQuery = $this->priceHistoryQueryFactory->createQuery();
    $prices = $priceQuery->filterByItemId($itemId)->orderByCreatedAt()->find();
    return $prices;
  }

  public function priceSearchQuery($query, $filters, $order="", $direction="")
  {
    if(!($query instanceof PriceQuery)){
      //if its a price query then we dont need the usePriceQuery
      $priceQuery = $query->usePriceQuery();
    }else{
      $priceQuery = $query;
    }
    
    foreach ($filters as $searchType => $search) {
      switch ($searchType) {
        case 'maxBuy':
          $priceQuery = $this->filterByMaxBuy($priceQuery,$search);
        break;
        case 'minBuy':
          $priceQuery = $this->filterByMinBuy($priceQuery,$search);
        break;
        case 'maxSell':
          $priceQuery = $this->filterByMaxSell($priceQuery,$search);
        break;
        case 'minSell':
          $priceQuery = $this->filterByMinSell($priceQuery,$search);
        break;
        case 'maxProfit':
          $priceQuery = $this->filterByMaxProfit($priceQuery,$search);
        break;
        case 'minProfit':
          $priceQuery = $this->filterByMinProfit($priceQuery,$search);
        break;
        case 'maxROI':
          $priceQuery = $this->filterByMaxROI($priceQuery,$search);
        break;
        case 'minROI':
          $priceQuery = $this->filterByMinROI($priceQuery,$search);
        break;
        case 'maxSupply':
          $priceQuery = $this->filterByMaxSupply($priceQuery,$search);
        break;
        case 'minSupply':
          $priceQuery = $this->filterByMinSupply($priceQuery,$search);
        break;
        case 'maxDemand':
          $priceQuery = $this->filterByMaxDemand($priceQuery,$search);
        break;
        case 'minDemand':
          $priceQuery = $this->filterByMinDemand($priceQuery,$search);
        break;
      }
    }
    $priceQuery = $this->orderBy($priceQuery, $order, $direction);
    return $priceQuery;
  }

  public function filterByMaxBuy($query,$value){
    $query = $query->filterByBuyPrice(array("max"=>$value));
    return $query;
  }

  public function filterByMinBuy($query,$value){
    $query = $query->filterByBuyPrice(array("min"=>$value));
    return $query;
  }

  public function filterByMaxSell($query,$value){
    $query = $query->filterBySellPrice(array("max"=>$value));
    return $query;
  }

  public function filterByMinSell($query,$value){
    $query = $query->filterBySellPrice(array("min"=>$value));
    return $query;
  }

  public function filterByMaxProfit($query,$value){
    $query = $query->filterByProfit(array("max"=>$value));
    return $query;
  }

  public function filterByMinProfit($query,$value){
    $query = $query->filterByProfit(array("min"=>$value));
    return $query;
  }

  public function filterByMaxROI($query,$value){
    $query = $query->filterByRoi(array("max"=>$value));
    return $query;
  }

  public function filterByMinROI($query,$value){
    $query = $query->filterByRoi(array("min"=>$value));
    return $query;
  }

  public function filterByMaxSupply($query,$value){
    $query = $query->filterBySellQty(array("max"=>$value));
    return $query;
  }

  public function filterByMinSupply($query,$value){
    $query = $query->filterBySellQty(array("min"=>$value));
    return $query;
  }

  public function filterByMaxDemand($query,$value){
    $query = $query->filterByBuyQty(array("max"=>$value));
    return $query;
  }

  public function filterByMinDemand($query,$value){
    $query = $query->filterByBuyQty(array("min"=>$value));
    return $query;
  }

  private function orderBy($priceQuery,$order='profit', $direction='ASC')
  {
    $direction = strtoupper($direction);
    $direction = $direction=='ASC'?Criteria::ASC:Criteria::DESC;
    switch ($order) {
      case 'buy':
        $priceQuery = $priceQuery->orderByBuyPrice($direction);
        break;
      
      case 'sell':
        $priceQuery = $priceQuery->orderBySellPrice($direction);
        break;
      
      case 'profit':
        $priceQuery = $priceQuery->orderByProfit($direction);
        break;
      
      case 'roi':
        $priceQuery = $priceQuery->orderByRoi($direction);
        break;
      
      case 'supply':
        $priceQuery = $priceQuery->orderBySellQty($direction);
        break;      
      
      case 'demand':
        $priceQuery = $priceQuery->orderByBuyQty($direction);
        break;
    }
    return $priceQuery;
  }
}