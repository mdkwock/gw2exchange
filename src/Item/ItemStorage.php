<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;

use \GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \Propel\Runtime\ActiveQuery\ModelCriteria;

use Propel\Runtime\Propel;
use GW2Exchange\Database\Map\ItemTableMap;
/**
 * 
 */
class ItemStorage
{
  protected $itemQueryFactory;
  protected $itemFactory;

  public function __construct(DatabaseQueryFactoryInterface $iqf,ItemFactoryInterface $if)
  {
    $this->itemQueryFactory = $iqf;
    $this->itemFactory = $if;
  }

  /**
   * a general search function that will call the applicable filters
   * @param  string[]  $filters    an array of the filters, with the key being the type the value being the search
   * @param  integer $page         the results page that we are retrieving
   * @param  integer $maxPerPage   the number of results returned
   * @return array                 an array of the results
   */
  public function search($filters, $order=null, $direction=null, $page=1, $maxPerPage=10){
    $itemQuery = $this->itemQueryFactory->createQuery();

$con = Propel::getWriteConnection(ItemTableMap::DATABASE_NAME);
$con->useDebug(true);
    foreach ($filters as $searchType => $query) {
      switch ($searchType) {
        case 'type':
          $itemQuery = $this->filterByType($itemQuery,$query);
        break;
        case 'subtype':
          $itemQuery = $this->filterBySubType($itemQuery,$query);
        break;
        case 'rarity':
          $itemQuery = $this->filterByRarity($itemQuery,$query);
        break;
        case 'minLevel':
          $itemQuery = $this->filterByMinLevel($itemQuery,$query);
        break;
        case 'maxLevel':
          $itemQuery = $this->filterByMaxLevel($itemQuery,$query);
        break;
        case 'name':
        default:
          $itemQuery = $this->filterByName($itemQuery,$query);
        break;
      }
    }
    $itemPager = $itemQuery->paginate($page, $maxPerPage);
    $items = $itemPager->getNbResults();
    $lastPage = ceil($items / $maxPerPage);
    $returns = array(
      "lastPage"=>$lastPage,
      "pageList"=>$itemPager->getLinks(5)
    );
    foreach ($itemPager as $item) {
      $returns[] = $item;
    }
    return $returns;
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

  public function filterByName($query, $itemName)
  {
    $query->filterByName($itemName);
    return $query;
  }

  public function filterByType($query, $typeName)
  {
    $query->useItemInfoQuery()
      ->filterByType($typeName)
    ->endUse();
    return $query;
  }

  public function filterBySubType($query, $subtype)
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

  public function filterByRarity($query, $rarity)
  {
    $query->useItemInfoQuery()
      ->filterByRarity($rarity)
    ->endUse();
    return $query;
  }

  public function filterByMinLevel($query, $minLvl)
  {
    $query->useItemInfoQuery()
      ->filterByLevel(array("min"=>$minLvl))
    ->endUse();
    return $query;
  }

  public function filterByMaxLevel($query, $maxLvl)
  {
    $query->useItemInfoQuery()
      ->filterByLevel(array("max"=>$maxLvl))
    ->endUse();
    return $query;
  }

  public function orderBy($query,$order='name', $direction='ASC')
  {
    $direction = $direction!='ASC'?'DESC':'ASC';
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