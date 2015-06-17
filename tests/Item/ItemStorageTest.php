<?php
use GW2Exchange\Item\ItemStorage;
use GW2Exchange\Database\Item;
use GW2Exchange\Database\ItemQueryFactory;

class ItemStorageTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->itemQueryFactory = $this->getMockBuilder('GW2Exchange\Database\ItemQueryFactory')
      ->setMethods(array('createQuery'))
      ->getMock();

    $this->itemQuery =  $this->getMockBuilder('GW2Exchange\Database\ItemQuery')
      ->setMethods(array('joinWith','filterByName','find'))
      ->getMock();
      
    $this->item = $this->getMockBuilder('GW2Exchange\Database\Item')
      ->setMethods(array('toArray'))
      ->getMock();

    $this->result = array(array("copper 1",4), array("small copper",6), array("copper stone",2), array("edible copper rock",97));

    $this->itemStorage = new ItemStorage($this->itemQueryFactory);


    $this->itemQueryFactory->method('createQuery')
        ->will($this->returnValue($this->itemQuery));

    $this->itemQuery->method('joinWith')
      ->will($this->returnValue($this->itemQuery));
    $this->itemQuery->method('filterByName')
      ->will($this->returnValue($this->itemQuery));
    $this->itemQuery->method('find')
      ->will($this->returnValue(array($this->item,$this->item,$this->item,$this->item)));

    $this->item->method('toArray')
      ->will($this->onConsecutiveCalls($this->result[0],$this->result[1],$this->result[2],$this->result[3]));
  }

  public function testSearchByName()
  {
    $query = "copper";

    $results = $this->itemStorage->searchByName($query);
    $this->assertEquals($this->result, $results);
  }


}