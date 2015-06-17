<?php
namespace GW2ledger\Listing;

use GW2ledger\Database\ListingQuery;
use GW2ledger\Signature\Listing\ListingFactoryInterface;
use GW2ledger\Signature\Listing\ListingParserInterface;

/**
 * This class creates the Listing objects
 */
class ListingFactory implements ListingFactoryInterface
{
  protected $listingParser;

  /**
   * constructor, supplies the factory with the classes it needs to create items
   */
  public function __construct(ListingParserInterface $lp)
  {
    $this->listingParser = $lp;
  }

  /** 
   * will create a single Listing using an array
   * @param   mixed[]  $attributes  an array with info on how to make the obj
   * @return  object                the object that was created with this process
   */
  public function createFromArray($arr)
  {
    if(!empty($arr[1])){
      //if there is more than one listing, only return the first
      $listing = ListingQuery::create()
       ->filterByItemId($arr['ItemId'])
       ->filterByType($arr['Type'])
       ->filterByUnitPrice($arr['UnitPrice'])
       ->findOneOrCreate();
      $listing->setAllFromArray($arr[0]);
      return $listing;
    }else{
      //assume it's an array for a single listing
      $listing = ListingQuery::create()
       ->filterByItemId($arr['ItemId'])
       ->filterByType($arr['Type'])
       ->filterByUnitPrice($arr['UnitPrice'])
       ->findOneOrCreate();
      $listing->setAllFromArray($arr);
      return $listing;
    }
  }

  /**
   * this function will return a single instance of an Listing
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Listing
   * @return  Listing      the created object
   */
  public function createFromJson($json)
  {
    $objs = $this->listingParser->parseJson($json); //take the string and make it into a formatted array
    if(!empty($objs[1])){
      //if there is more than one listing, only return the first
      return $this->createFromArray($objs[0]);
    }else{
      //assume it's an array for a single listing
      return $this->createFromArray($objs);      
    }
  }

  /**
   * creates a set of listings from an array of listings data
   * @param  string[] $array  an array which has all of the info to create a set of listings
   * @return Listing[]        the set of listings represented by the data
   */
  public function createManyFromArray($array)
  {
    $results = array();
    foreach($array as $obj)
    {
      $results[] = $this->createFromArray($obj);
    }
    return $results;
  }

  /**
   * creates a set of listings from a json string of listings data
   *
   * this will probably be the one that is used the most
   * @param  string $json  an json string which has all of the info to create a set of listings
   * @return Listing[]        the set of listings represented by the data
   */
  public function createManyFromJson($json)
  {
    $objs = $this->listingParser->parseJson($json); //take the string and make it into a formatted array
    $returns = array();
    foreach($objs as $itemList){
      //for every item get all of the listings associated
      $temp = $this->createManyFromArray($itemList);
      $itemId = reset($itemList)['ItemId'];//get the item id from the first listing
      $returns[$itemId] = $temp;
    }
    return $returns;
  }
}