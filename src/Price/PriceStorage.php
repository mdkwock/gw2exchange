<?php
namespace GW2Exchange\Price;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;

use \GW2Exchange\Signature\Price\PriceParserInterface;
use \GW2Exchange\Signature\Price\PriceFactoryInterface;
use \GW2Exchange\Price\Price;

/**
 * 
 */
class PriceStorage
{
  protected $priceQueryFactory;
  protected $priceHistoryQueryFactory;
  protected $priceFactory;

  public function __construct(DatabaseQueryFactoryInterface $pqf,DatabaseQueryFactoryInterface $phqf, PriceFactoryInterface $pf)
  {
    $this->priceQueryFactory = $pqf;
    $this->priceHistoryQueryFactory = $phqf;
    $this->priceFactory = $pf;
  }

  public function getByItemIds($itemIds)
  {

    $priceQuery = $this->priceQueryFactory->createQuery();
    $prices = $priceQuery->findPKs($itemIds);
    if(!empty($prices)){
      $prices = $prices->getData();
    }
    return $prices;
  }

  public function getPriceHistory($itemId){
    $priceQuery = $this->priceHistoryQueryFactory->createQuery();
    $prices = $priceQuery->filterByItemId($itemId)->orderByCreatedAt()->find();
    return $prices;
  }

  
}