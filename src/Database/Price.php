<?php
namespace GW2Exchange\Database;

use GW2Exchange\Database\Base\Price as BasePrice;
use GW2Exchange\Database\PriceQuery;
use GW2Exchange\Database\PriceHistoryQuery;
use GW2Exchange\Database\PriceHistory;
use GW2Exchange\Database\Map\PriceTableMap;
use GW2Exchange\Signature\Database\DatabaseObjectInterface;
use Propel\Runtime\Connection\ConnectionInterface;
use GW2Exchange\Taxes\TaxService;
/**
 * Skeleton subclass for representing a row from the 'item_summary' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Price extends BasePrice implements DatabaseObjectInterface
{
  protected static $tableColumnMap;
  protected $minCacheTime = 4;
  /**
   * this function is used as a shortcut to the propel table mapping process
   * will return an array of all of the columns that are controlled by this object
   * @return string[]     all of the fields that this object has
   */
  public function getFields()
  {
    if(empty(static::$tableColumnMap)){
      //if we have not already generated a map
      $baseItemTable = PriceTableMap::getTableMap();
      $baseItemColumns = $baseItemTable->getColumns();
      //save to cache it
      static::$tableColumnMap = array_map('strtolower', array_keys($baseItemColumns));
    }
    return static::$tableColumnMap;
  }

  /**
   * sets all the fields an object
   * @param  int $item_id    [description]
   * @param  int $buy_price  [description]
   * @param  int $sell_price [description]
   * @param  int $buy_qty    [description]
   * @param  int $sell_qty   [description]
   * @return [type]             [description]
   */
  public function setAll($item_id, $buy_price, $sell_price, $buy_qty, $sell_qty, $created_at=null)
  {
    $this->setItemId($item_id);
    $this->setBuyPrice($buy_price);
    $this->setSellPrice($sell_price);
    $this->setBuyQty($buy_qty);
    $this->setSellQty($sell_qty);
    $this->setUpdatedAt(time());
    if($created_at != null){
      //add created at to allow for importing old data
      $this->setCreatedAt($created_at);
    }
    if(!empty($buy_price) && !empty($sell_price)){
      //profit and roi only exist for items with both demand and supply
      $profit = TaxService::applyTaxes($sell_price) - $buy_price;
      $roi = $profit / $buy_price * 100;
      $this->setProfit($profit);
      $this->setRoi($roi);
    }
  }
  
  /**
   * sets all the fields of an object using an array of attributes
   * @param  array $attributes  an array of the attributes necessary to create the object
   * @return object             the object that is created using the array
   */
  public function setAllFromArray($values)
  {
    $createdAt = empty($values['CreatedAt'])?null:$values['CreatedAt'];
    return $this->setAll($values['ItemId'], $values['BuyPrice'], $values['SellPrice'], $values['BuyQty'], $values['SellQty'], $createdAt);
  }

  /**
   * Code to be run before persisting the object
   * Creates a Price History Record of the previous value and saves it to the db
   * @param  ConnectionInterface $con
   * @return boolean
   */
  public function preSave(ConnectionInterface $con =  null)
  {
    $now = time();
    //check to see if we have not already made this record
    $priceHistoryQuery = new PriceHistoryQuery();
    $priceHistory = $priceHistoryQuery->filterByItemId($this->item_id)->lastCreatedFirst()->findOneOrCreate();
    $existing = $priceHistory->hash();
    $new = $this->hash();
    if($existing == $new){
      //dd("same");
      //if the old price history and the price we are about to save are the same
      $this->setCacheTime($this->getCacheTime()*2);//double the cache time
    }else{
      //d($priceHistory);
      //d($this);
      //dd('diff');
      $this->setCacheTime($this->minCacheTime);//else reset the cache time to 1
    }
    if($priceHistory->getCreatedAt() != $this->getUpdatedAt()){
      //if there is no existing price history entry for this update time
      $priceHistory = new PriceHistory();
      $priceHistory->fromArray($this->toArray());
      $priceHistory->setCreatedAt($now);
      $this->addPriceHistory($priceHistory);
    }else{
      //there is an existing price history for this update time
    }
      if(empty($this->getMaxBuy())){
        //if there is not already a max buy set
        //then we have to calculate and set all of them
        $stmt = $con->prepare('SELECT MAX(buy_price), MIN(buy_price), MAX(sell_price), MIN(sell_price) FROM price_history WHERE price_history.ITEM_ID = :p1');
        $stmt->bindValue(':p1', $this->getItemId());
        $stmt->execute();
        $aggregates = $stmt->fetch();
        $this->setMaxBuy($aggregates['MAX(buy_price)']);
        $this->setMinBuy($aggregates['MIN(buy_price)']);
        $this->setMaxSell($aggregates['MAX(sell_price)']);
        $this->setMinSell($aggregates['MIN(sell_price)']);
      }else{
        //else they are already set so we can just update if necessary
        if($this->buy_price > $this->getMaxBuy()){
          //if the new price is higher than the previous max
          $this->setMaxBuy($this->buy_price);
        }elseif($this->buy_price < $this->getMinBuy()){
          //if the new price is higher than the previous max
          $this->setMinBuy($this->buy_price);
        }

        if($this->sell_price > $this->getMaxSell()){
          //if the new price is higher than the previous max
          $this->setMaxSell($this->sell_price);
        }elseif($this->sell_price < $this->getMinSell()){
          //if the new price is higher than the previous max
          $this->setMinSell($this->sell_price);
        }
      }
    //dd($this);
    return true;//continue with the save
  }

  /**
   * this function creates a hash of the data contained in this object, to allow for quick checks of whether or not the object has been updated
   * @return [type] [description]
   */
  public function hash($arr = array()){
    if(empty($arr)){
      $arr = array(
        'buy_price'=>$this->getBuyPrice(),
        'buy_qty'=>$this->getBuyQty(),
        'sell_price'=>$this->getSellPrice(),
        'sell_qty'=>$this->getSellQty(),
      ); 
    }    
    $hash = md5(json_encode($arr));
    return $hash;
  }
}
