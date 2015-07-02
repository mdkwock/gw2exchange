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
