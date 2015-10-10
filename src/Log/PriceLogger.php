<?php
namespace GW2Exchange\Log;

use \GW2Exchange\Signature\Connection\WebScraperInterface;
use GW2Exchange\Database\RequestsLog;

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
   * @param  PriceHistory|int         $price        either a price object or the id of the price in question
   * @param  boolean        $cacheHit        whether the price we had was considered a non-expired price
   * @param  boolean|null   $cacheCorrect    if the price we had was considered non-expired, was it correct
   * @return  null
   */
  public function logPriceRequest($priceHistory=null,$cacheHit=false,$cacheCorrect=null){
    $entry = new PriceRequestLogEntry();
    $entry->fromArray(array(
      'priceHistoryId'=>$priceHistoryIdId,
      'cacheHit'=>$cacheHit,
      'cacheCorrect'=>$cacheCorrect
    ));
    $entry->save();
  }

  public function logPriceUpdateCheck($priceHistory, $isModified){
    $entry = new PriceUpdateCheckLogEntry();
    $entry->fromArray(array(
      'priceHistoryId'=>$priceHistoryId,
      'isChanged'=>$isChanged
    ));
    $entry->save(); 
  }
}
/*
<column name="id" type="integer" primaryKey="true" autoIncrement="true" />
    <column name="url" type="integer" required="true" />
    <column name="gw2ServerUrl" type="integer" required="true" />
    <column name="price_history_id" type="integer" required="true" />
    <column name="cache_hit" type="integer" required="true" />
    <column name="cache_correct" type="integer" />
    <foreign-key foreignTable="price_history">
      <reference local="price_history_id" foreign="id"/>
    </foreign-key>
    <behavior name="timestampable">
      <parameter name="disable_updated_at" value="true" />
 */