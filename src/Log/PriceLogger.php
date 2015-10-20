<?php
namespace GW2Exchange\Log;

use \GW2Exchange\Signature\Connection\WebScraperInterface;
use GW2Exchange\Database\RequestsLog;
use GW2Exchange\Database\PriceUpdateCheckLogEntry;
use GW2Exchange\Database\PriceRequestLogEntry;

use GW2Exchange\Listing\ListingFactory;
use GW2Exchange\Signature\Listing\ListingAssemblerInterface;

use GuzzleHttp\Exception\ClientException;

/**
 * This class is to record visits to different items and report whether they were cached successfully
 */
class PriceLogger
{
  /**
   * this function records when an item is requested by a visitor
   * we just record the price id because it will have all of the information about the item that we need
   * 
   * @param  PriceHistory         $priceHistory         a price object of the price in question
   * @param  boolean        $cacheHit        whether the price we had was considered a non-expired price
   * @param  boolean|null   $cacheCorrect    if the price we had was considered non-expired, was it correct
   * @return  null
   */
  public function logPriceRequest($priceHistory,$cacheHit=false,$cacheCorrect=null){
    $entry = new PriceRequestLogEntry();
    $entry->fromArray(array(
      'CacheHit'=>$cacheHit,
      'CacheCorrect'=>$cacheCorrect
    ));
    $priceHistory->addPriceRequestLogEntry($entry);
  }

  /**
   * records when this item gets checked for updates
   * @param  PriceHistory  $priceHistory  the price history of the item we are looking at
   * @param  boolean $isDifferent          has the price changed so we created a new object
   * @return [type]                [description]
   */
  public function logPriceUpdateCheck($priceHistory, $isDifferent=true){
    $entry = new PriceUpdateCheckLogEntry();
    $entry->fromArray(array(
      'IsDifferent'=>$isDifferent
    ));
    $priceHistory->addPriceUpdateCheckLogEntry($entry);
  }
}