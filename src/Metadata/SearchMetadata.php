<?php
namespace GW2Exchange\Metadata;

use GW2Exchange\Signature\Maintenance\MaintenanceInterface;

use GW2Exchange\Database\ItemQueryFactory;
use GW2Exchange\Database\Map\ItemDetailTableMap;
use GW2Exchange\Database\ItemDetailQuery as ItemDetailQuery;
use Propel\Runtime\Propel;

/**
 * This class is made so that we can draw misc facts about the data, like types,rarities
 */
class SearchMetadata
{
  protected $itemQueryFactory;

  public function __construct(ItemQueryFactory $iqf)
  {
    $this->itemQueryFactory = $iqf;
  }

  public function getTypes(){
    $con = Propel::getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
    $sql = "SELECT DISTINCT(item_type) FROM item_detail";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getSubtypes()
  {
    $con = Propel::getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
    $sql = "SELECT DISTINCT(value) FROM item_item_detail WHERE item_detail_id IN (SELECT id from item_detail WHERE label='type')";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $subtypes = $stmt->fetchAll();
    $results = array();
    foreach ($subtypes as $subtype) {
      $results[] = array(
        "value"=>json_decode($subtype['value'])
      );
    }
    return $results;
  }

  public function getRarities(){
    $con = Propel::getWriteConnection(ItemDetailTableMap::DATABASE_NAME);
    $sql = "SELECT DISTINCT(rarity) FROM item_info";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}