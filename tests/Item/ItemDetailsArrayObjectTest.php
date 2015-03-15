<?php

use GW2ledger\Item\ItemDetailsArrayObject;
use GW2ledger\Database\Item;

class ItemDetailsArrayObjectTest extends PHPUnit_Framework_TestCase
{
  protected $details;
  
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
  }

  public function testConstruct()
  {
    $itemId = 1;
    $itemDetails = new ItemDetailsArrayObject();
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
  public function testGetArray($itemDetails)
  {
    $array = $itemDetails->getArray();
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
}