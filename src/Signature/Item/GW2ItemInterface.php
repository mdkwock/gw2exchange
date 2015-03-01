<?php
namespace GW2ledger\Signature\Item;

/**
 * This interface assembles a GW2Item
 */
interface GW2ItemInterface
{
  /**
   * default constructor, creates an item with nothing in it to start
   */
  public function __construct();

  /**
   * this function will return an instance of GW2ItemInterface
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  GW2ItemInterface       the created object
   */
  public static function createFromJson($json);

  /**
   * saves the item to a data store
   * @throws Exception   if save failed
   * @return 
   */
  public function save();
}