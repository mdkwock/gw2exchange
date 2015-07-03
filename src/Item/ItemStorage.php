<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;

use \GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \Propel\Runtime\ActiveQuery\ModelCriteria;
use GW2Exchange\Database\ItemQuery;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\ItemTableMap;
/**
 * 
 */
class ItemStorage
{
  protected $itemQueryFactory;
  protected $itemFactory;
  protected $stmt; //this is a statement object stored for use in the custom query functions

  public function __construct(DatabaseQueryFactoryInterface $iqf,ItemFactoryInterface $if)
  {
    $this->itemQueryFactory = $iqf;
    $this->itemFactory = $if;
  }

  public function prepareCustomQuery($sql){

    $con = Propel::getWriteConnection(ItemTableMap::DATABASE_NAME);
    $this->stmt = $con->prepare($sql);
  }

  public function fetchAllCustomQuery(){
    $this->stmt->execute();
    $data = $this->stmt->fetchAll();
    return $data;
  }

  /**
   * suggests a name from the given partial
   * searches for wildcards on both sides
   * @param  [type] $partial [description]
   * @return [type]          [description]
   */
  public function suggestName($partial)
  {
    $itemQuery = $this->itemQueryFactory->createQuery();
    $itemQuery = $this->filterByName($itemQuery, '%'.$partial.'%');
    $items = $itemQuery->select(array('Name','Id'))->find()->toArray();
    return $items;
  }

  public function getAllItemIds(){
    $itemQuery = $this->itemQueryFactory->createQuery()->select('Id');
    $itemIds = $itemQuery->find()->toArray();
    return $itemIds;
  }

  /**
   * a general search function that will call the applicable filters
   * @param  string[]  $filters    an array of the filters, with the key being the type the value being the search
   * @return array                 an array of the results
   */
  public function itemSearchQuery($query, $filters, $order="name",$dir="asc"){
    if(!($query instanceof ItemQuery)){
      //if its an item query then we dont need the useItemQuery
      $itemQuery = $query->useItemQuery();
    }else{
      $itemQuery = $query;
    }
    
    foreach ($filters as $searchType => $search) {
      switch ($searchType) {
        case 'type':
          $itemQuery = $this->filterByType($itemQuery,$search);
        break;
        case 'subtype':
          $itemQuery = $this->filterBySubType($itemQuery,$search);
        break;
        case 'rarity':
          $itemQuery = $this->filterByRarity($itemQuery,$search);
        break;
        case 'minLevel':
          $itemQuery = $this->filterByMinLevel($itemQuery,$search);
        break;
        case 'maxLevel':
          $itemQuery = $this->filterByMaxLevel($itemQuery,$search);
        break;
        case 'name':
          $itemQuery = $this->filterByName($itemQuery,$search);
        break;
      }
    }
    $itemQuery = $this->orderBy($itemQuery,$order,$dir);
    if(!($query instanceof ItemQuery)){
      $itemQuery->endUse();
      $itemQuery = $query;
    }
    return $itemQuery;
  }

  private function filterByName($query, $itemName)
  {
    $query->filterByName($itemName);
    return $query;
  }

  private function filterByType($query, $typeName)
  {
    $query->useItemInfoQuery()
      ->filterByType($typeName)
    ->endUse();
    return $query;
  }

  private function filterBySubType($query, $subtype)
  {
    //subtypes are details, which are all json_encoded before entered into the db
    $subtype = json_encode($subtype);
    $query->useItemItemDetailQuery()
      ->useItemDetailQuery()
        ->filterByLabel('type')
      ->endUse()
      ->filterByValue($subtype)
    ->endUse();
    return $query;
  }

  private function filterByRarity($query, $rarity)
  {
    $query->useItemInfoQuery()
      ->filterByRarity($rarity)
    ->endUse();
    return $query;
  }

  private function filterByMinLevel($query, $minLvl)
  {
    $query->useItemInfoQuery()
      ->filterByLevel(array("min"=>$minLvl))
    ->endUse();
    return $query;
  }

  private function filterByMaxLevel($query, $maxLvl)
  {
    $query->useItemInfoQuery()
      ->filterByLevel(array("max"=>$maxLvl))
    ->endUse();
    return $query;
  }

  private function orderBy($query,$order='name', $direction='ASC')
  {
    $direction = strtoupper($direction);
    $direction = $direction=='ASC'?Criteria::ASC:Criteria::DESC;
    if(!empty($order)){
      switch ($order) {
        case 'name':
          $query = $query->orderByName($direction);
        break;
      }
    }
    return $query;
  }
}