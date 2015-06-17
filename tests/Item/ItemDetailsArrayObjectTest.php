<?php

use GW2Exchange\Item\ItemDetailsArrayObject;
use GW2Exchange\Item\ItemDetailFactory;
use GW2Exchange\Item\ItemItemDetailFactory;
use GW2Exchange\Database\ItemDetail;
use GW2Exchange\Database\ItemItemDetail;
use GW2Exchange\Database\Item;

class ItemDetailsArrayObjectTest extends PHPUnit_Framework_TestCase
{
  
  public function setUp(){    
    $this->type = "Weapon";
    $this->details = array (
      'type' => 'Staff',
      'damage_type' => 'Physical',
      'min_power' => 146,
      'max_power' => 165,
      'defense' => 0,
      'infusion_slots' => array ( ),
      'infix_upgrade' => array (
          'attributes' => array ( ),
      )
    );
    $this->itemDetailFactory = $this->getMockBuilder('GW2Exchange\Item\ItemDetailFactory')
      ->setMethods(array('create'))
      ->getMock();
    $this->itemItemDetailFactory = $this->getMockBuilder('GW2Exchange\Item\ItemItemDetailFactory')
      ->setMethods(array('create'))
      ->getMock();
  }

  public function testConstruct()
  {
    $itemId = 1;

    $json = "[1,3,5,7,9]"; //this is the return from the endpoint
    $return = array(1,3,5,7,9); //this is what we expect to get

    $itemDetail = $this->getMockBuilder('GW2Exchange\Database\ItemDetail')
      ->setMethods(array('isNew','save'))
      ->getMock();
    $itemDetail->method('isNew')
      ->will($this->returnValue(true));
    $itemDetail->method('save')
      ->will($this->returnValue(null));

    $this->itemDetailFactory->method('create')
      ->will($this->returnValue($itemDetail));

    $itemItemDetail = $this->getMockBuilder('GW2Exchange\Database\ItemItemDetail')
      ->setMethods(array('isNew','save'))
      ->getMock();
    $itemItemDetail->method('isNew')
      ->will($this->returnValue(true));
    $itemItemDetail->method('save')
      ->will($this->returnValue(null));
    $this->itemItemDetailFactory->method('create')
      ->will($this->returnValue($itemItemDetail));

    $itemDetails = new ItemDetailsArrayObject($this->itemDetailFactory, $this->itemItemDetailFactory);
    $itemDetails->setAll($itemId, $this->type, $this->details);
    $this->assertNotEmpty($itemDetails);
    $this->assertEquals($this->details['damage_type'],$itemDetails->getByName('damage_type'));
    $this->assertEquals($this->details['infix_upgrade'],$itemDetails->getByName('infix_upgrade'));
    return $itemDetails;
  }


  /**
   * @depends testConstruct
   */
  public function testGetFields($itemDetails)
  {
    $keys = $itemDetails->getFields();
    $this->assertEquals(array_map('strtolower',array_keys($this->details)),$keys);
  }

  
  /**
   * @depends testConstruct
   */
  public function testToArray($itemDetails)
  {
    $array = $itemDetails->toArray();
    $this->assertEquals($this->details,$array);
  }

  
  /**
   * @depends testConstruct
   */
  public function testGetByName($itemDetails)
  {
    $key = key($this->details);
    $value = $itemDetails->getByName($key);
    $this->assertEquals($this->details[$key],$value);
    return $itemDetails;
  }

  
  /**
   * @depends testGetByName
   */
  public function testSetValue($itemDetails)
  {
    $key = key($this->details);
    $value = "testing";
    $this->details[$key] = $value; //set the test with this in case the set test runs before the get
    $itemDetails->setValue($key,$value);
    $this->assertNotEmpty($key);
    $this->assertEquals($value,$itemDetails->getByName($key));
    
  }
/*
Im not sure how to inject mocks into this
  public function testSave()
  {
    $itemId = 1;
    $itemDetails = new ItemDetailsArrayObject();
    $itemDetails->setAll($itemId, $this->type, $this->details);
    $this->assertNotEmpty($itemDetails);
    $this->assertEquals($this->details['damage_type'],$itemDetails->getByName('damage_type'));
    $this->assertEquals($this->details['infix_upgrade'],$itemDetails->getByName('infix_upgrade'));
    return $itemDetails;
  }
  */
}