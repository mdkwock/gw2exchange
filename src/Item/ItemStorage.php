<?php
namespace GW2Exchange\Item;

use GW2Exchange\Signature\Database\DatabaseQueryFactoryInterface;

use \GW2Exchange\Signature\Item\ItemPiecesFactoryInterface;
use \GW2Exchange\Signature\Item\ItemFactoryInterface;
use \Propel\Runtime\ActiveQuery\ModelCriteria;

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
   * search for items using the name
   * @param  string  $query  the query we are looking for
   * @return string[]        the item names and ids
   */
  public function searchByName($query, $page=1, $maxPerPage=10){   
    $itemQuery = $this->itemQueryFactory->createQuery();
    //get all the items, as well as getting the price info
    $itemQuery = $this->filterByName($itemQuery, '%'.$partial.'%');
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
}