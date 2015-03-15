<?php

use GW2ledger\Item\Item;
use \GW2ledger\Database\Item as BaseItem;
use \GW2ledger\Database\ItemInfo;
use \GW2ledger\Item\ItemDetailsArrayObject;

class ItemTest extends PHPUnit_Framework_TestCase
{

  public function setUp()
  {    
    $this->itemFields = array("name");                                
    $this->baseItem = $this->getMockBuilder('\GW2ledger\Database\Item')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('getFields','setAllFromArray','save'))
                    ->getMock();


    $this->itemInfoFields = array("info1","info2");
    $this->itemInfo = $this->getMockBuilder('\GW2ledger\Database\ItemInfo')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('getFields','getByName','setAllFromArray','save'))
                    ->getMock();

    $this->itemDetailsFields = array("detailed");
    $this->itemDetails = $this->getMockBuilder('\GW2ledger\Item\ItemDetailsArrayObject')
                    //->setConstructorArgs(array('404',array(),null,array()))
                    ->setMethods(array('getFields','setByName','setAllFromArray','save'))
                    ->getMock();

    //return the fields when asked
    $this->baseItem->method('getFields')
        ->will($this->returnValue($this->itemFields));

    $this->itemInfo->method('getFields')
        ->will($this->returnValue($this->itemInfoFields));

    $this->itemDetails->method('getFields')
        ->will($this->returnValue($this->itemDetailsFields));
  }

  public function testGetFields()
  {

    $this->baseItem->expects($this->once())
                 ->method('getFields');
    $this->itemInfo->expects($this->once())
                 ->method('getFields');
    $this->itemDetails->expects($this->once())
                 ->method('getFields');
    $item = new Item($this->baseItem,$this->itemInfo,$this->itemDetails);
    $fields = $item->getFields();

    $this->assertEquals(array_merge($this->itemFields,$this->itemInfoFields,$this->itemDetailsFields),$fields);
  }

  public function testGetByName()
  {
    $this->itemInfo->expects($this->once())
                 ->method('getByName')
                 ->with($this->equalTo('info1'))
                 ->will($this->returnValue('value'));
    $item = new Item($this->baseItem,$this->itemInfo,$this->itemDetails);
    $value = $item->getByName('info1');
    $this->assertEquals('value',$value);
  }

  public function testSetByName(){
    $this->itemDetails->expects($this->once())
                 ->method('setByName')
                 ->with($this->equalTo('detailed'),$this->equalTo('value2'));
    $item = new Item($this->baseItem,$this->itemInfo,$this->itemDetails);
    $item->setByName('detailed','value2');
  }

  public function testSetAllFromArray()
  {
    $this->baseItem->expects($this->once())
                 ->method('setAllFromArray');
    $this->itemInfo->expects($this->once())
                 ->method('setAllFromArray');
    $this->itemDetails->expects($this->once())
                 ->method('setAllFromArray');
    $item = new Item($this->baseItem,$this->itemInfo,$this->itemDetails);
    $item->setAllFromArray(array('stuff'=>'values'));
  }

  public function testSave()
  {

    $this->baseItem->expects($this->once())
                 ->method('save');

    $this->itemInfo->expects($this->once())
                 ->method('save');

    $this->itemDetails->expects($this->once())
                 ->method('save');
    $item = new Item($this->baseItem,$this->itemInfo,$this->itemDetails);
    $item->save();
  }
}