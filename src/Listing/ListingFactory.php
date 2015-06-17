<?php
namespace GW2Exchange\Listing;

use GW2Exchange\Database\ListingQuery;
use GW2Exchange\Signature\Listing\ListingFactoryInterface;

/**
 * This class creates the Listing objects
 */
class ListingFactory implements ListingFactoryInterface
{

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct()
  {
  }

  /** 
   * will create a single Listing using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($arr)
  {
    $listing = ListingQuery::create()
     ->filterByItemId($arr['ItemId'])
     ->filterByType($arr['Type'])
     ->filterByUnitPrice($arr['UnitPrice'])
     ->findOneOrCreate();
    $listing->setAllFromArray($arr);
    return $listing;
  }
}