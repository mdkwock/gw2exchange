<?php
namespace GW2ledger\Signature\Item;

/**
 * This interface is the Item object class facade
 */
interface ItemFactoryInterface
{
  /**
   * constructor, supplies the factory with the classes it needs to create
   */
  public function __construct();

  /**
   * this function will return an instance of GW2ItemInterface
   * with values that are from the json string passed in
   * @param   string  $json           a json string representing the Item
   * @return  GW2ItemInterface       the created object
   */
  public function createFromJson($json);
}