<?php
namespace GW2ledger\Signature\Listing;

use GW2ledger\Signature\Base\FactoryInterface;

/**
 * This interface is for creating listing objects
 */
interface ListingFactoryInterface extends FactoryInterface
{
  /**
   * this function will return an instance of an Item
   * with values that are given in the json string passed in
   * @param   string    $json           a json string representing the Item
   * @return  Item      the created object
   */
  public function createFromJson($json);

  /**
   * creates a set of listings from an array of listings data
   * @param  string[] $array  an array which has all of the info to create a set of listings
   * @return Listing[]        the set of listings represented by the data
   */
  public function createManyFromArray($array);

  /**
   * creates a set of listings from a json string of listings data
   * @param  string $json  an json string which has all of the info to create a set of listings
   * @return Listing[]        the set of listings represented by the data
   */
  public function createManyFromJson($json);
}