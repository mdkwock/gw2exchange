<?php
namespace GW2Exchange\Search;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;
use \GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \Propel\Runtime\ActiveQuery\ModelCriteria;
use GW2Exchange\Database\ItemQuery;
use GW2Exchange\Item\ItemStorage;
use GW2Exchange\Price\PriceStorage;

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

  public function __construct(DatabaseQueryFactoryInterface $iqf, DatabaseQueryFactoryInterface $pqf, ItemStorage $is, PriceStorage $ps)
  {
    $this->itemQueryFactory = $iqf;
    $this->priceQueryFactory = $pqf;
    $this->itemStorage = $is;
    $this->priceStorage = $ps;
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
    foreach ($pricePager as $price) {
      $item = $price->getItem();
      $temp = array(
        'id'=>$item->getId(),
        'name'=>$item->getName(),
        'icon'=>$item->getIcon(),
        'rarity'=>$item->getItemInfo()->getRarity(),
        'buy'=>$price->getBuyPrice(),
        'sell'=>$price->getSellPrice(),
        'maxBuy'=>$price->getMaxBuy(),
        'maxSell'=>$price->getMaxSell(),
        'supply'=>$price->getSellQty(),
        'demand'=>$price->getBuyQty(),
        'profit'=>$price->getProfit(),
        'roi'=>$price->getRoi(),
      );

      $returns[] = $temp;
    }
    return $returns;
  }
}