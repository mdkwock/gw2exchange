<?php
namespace GW2Exchange\Search;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;
use \GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \Propel\Runtime\ActiveQuery\ModelCriteria;
use GW2Exchange\Database\ItemQuery;
use GW2Exchange\Item\ItemStorage;
use GW2Exchange\Price\PriceStorage;
use GW2Exchange\Price\PriceAssembler;
use GW2Exchange\Log\PriceLogger;

use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\ItemTableMap;
/**
 * 
 */
class ItemSearch
{
  protected $itemQueryFactory;
  protected $priceQueryFactory;
  protected $itemStorage;
  protected $priceStorage;
  private $priceAssembler;
  private $priceLogger;

  public function __construct(DatabaseQueryFactoryInterface $iqf, DatabaseQueryFactoryInterface $pqf, ItemStorage $is, PriceStorage $ps, PriceAssembler $pa, priceLogger $pl)
  {
    $this->itemQueryFactory = $iqf;
    $this->priceQueryFactory = $pqf;
    $this->itemStorage = $is;
    $this->priceStorage = $ps;
    $this->priceAssembler = $pa;
    $this->priceLogger = $pl;
  }

  /**
   * a general search function that will call the applicable filters
   * @param  string[]  $filters    an array of the filters, with the key being the type the value being the search
   * @param  integer $page         the results page that we are retrieving
   * @param  integer $maxPerPage   the number of results returned
   * @return array                 an array of the results
   */
  public function searchItems($filters, $order=null, $direction=null, $page=1, $maxPerPage=10){
    $priceQuery = $this->priceQueryFactory->createQuery();
    $priceQuery = $priceQuery
      ->joinWith('Item')
      ->joinWith('Item.ItemInfo');
    $priceQuery = $this->priceStorage->priceSearchQuery($priceQuery,$filters,$order,$direction);
    $priceQuery = $this->itemStorage->itemSearchQuery($priceQuery, $filters,$order,$direction);
    $pricePager = $priceQuery->paginate($page, $maxPerPage);
    $prices = $pricePager->getNbResults();
    $lastPage = ceil($prices / $maxPerPage);
    $returns = array(
      "lastPage"=>$lastPage,
      "pageList"=>$pricePager->getLinks(5)
    );
    $priceData = array();
    $itemIds = array();
    foreach ($pricePager as $price) {
      $itemId = $price->getItemId();
      $itemIds[] = $itemId;
      $priceData[$itemId] = $price;
      $item = $price->getItem();
      $temp = array(
        'id'=>$item->getId(),
        'name'=>$item->getName(),
        'icon'=>$item->getIcon(),
        'rarity'=>$item->getItemInfo()->getRarity(),
        'buy'=>$price->getBuyPrice(),
        'sell'=>$price->getSellPrice(),
        'minBuy'=>$price->getMinBuy(),
        'maxSell'=>$price->getMaxSell(),
        'supply'=>$price->getSellQty(),
        'demand'=>$price->getBuyQty(),
        'profit'=>$price->getProfit(),
        'roi'=>$price->getRoi(),
      );
      $returns[] = $temp;
    }

    //get a set of answers from the gw2 servers to compare with
    $serverResponse = $this->priceAssembler->getByItemIds($itemIds);
    //for this task re-index the server prices by item it so that it is easier to look up
    $serverPrices = array();
    foreach ($serverResponse as $price) {
      $key = $price->getItemId();
      $serverPrices[$key] = $price;
    }

      //create a new log entry  for the lookup
      foreach ($priceData as $key => $price) {
        $cacheCorrect = null;
        $priceHistory = $price->getPriceHistories()->pop();//the most recent price history is the same as the current price
        $cacheTime = $price->getCacheTime();
        $lastUpdated = $price->getUpdatedAt();
        if(time() < $lastUpdated->getTimestamp() +($cacheTime*60*1000)){
          //if the time now is before the next cache update time, then the cache is hit
          $cacheHit = true;
          //if it does hit the cache check to see if the cache is correct
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

    return $returns;
  }
}