<?php

namespace GW2Exchange\Database;

use GW2Exchange\Database\Base\PriceHistory as BasePriceHistory;
use Propel\Runtime\Connection\ConnectionInterface;


/**
 * Skeleton subclass for representing a row from the 'price_history' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class PriceHistory extends BasePriceHistory
{

  /**
   * Code to be run before persisting the object
   * Creates a Price History Record of the previous value and saves it to the db
   * @param  ConnectionInterface $con
   * @return boolean
   */
  public function preSave(ConnectionInterface $con = null){
    $price = $this->getPrice();
    if(!empty($price)){

      if(empty($price->getMaxBuy())){
        //if there is not already a max buy set
        //then we have to calculate and set all of them
        $stmt = $con->prepare('SELECT MAX(buy_price), MIN(buy_price), MAX(sell_price), MIN(sell_price) FROM price_history WHERE price_history.ITEM_ID = :p1');
        $stmt->bindValue(':p1', $this->getItemId());
        $stmt->execute();
        $aggregates = $stmt->fetch();

        $price->setMaxBuy($aggregates['MAX(buy_price)']);
        $price->setMinBuy($aggregates['MIN(buy_price)']);
        $price->setMaxSell($aggregates['MAX(sell_price)']);
        $price->setMinSell($aggregates['MIN(sell_price)']);
      }else{
        //else they are already set so we can just update if necessary
        if($this->buy_price > $price->getMaxBuy()){
          //if the new price is higher than the previous max
          $price->setMaxBuy($this->buy_price);
        }elseif($this->buy_price < $price->getMinBuy()){
          //if the new price is higher than the previous max
          $price->setMinBuy($this->buy_price);
        }

        if($this->sell_price > $price->getMaxSell()){
          //if the new price is higher than the previous max
          $price->setMaxSell($this->sell_price);
        }elseif($this->sell_price < $price->getMinSell()){
          //if the new price is higher than the previous max
          $price->setMinSell($this->sell_price);
        }
      }
    }
    return true;
  }
}
