<?php
use \GW2Exchange\Maintenance\ItemMaintenance;

use GW2Exchange\Item\ItemAssembler;
use GW2Exchange\Database\ItemQueryFactory;
use GW2Exchange\Database\ItemQuery;
use GW2Exchange\Database\Item;

class ItemMaintenanceTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){
    $this->itemAssembler = $this->getMockBuilder('GW2Exchange\Item\ItemAssembler')
      ->disableOriginalConstructor()
      ->setMethods(array('getIdList','getByIds'))
      ->getMock();

    $this->itemQueryFactory =  $this->getMockBuilder('GW2Exchange\Database\ItemQueryFactory')
      ->setMethods(array('createQuery'))
      ->getMock();
      
    $this->itemQuery =  $this->getMockBuilder('GW2Exchange\Database\ItemQuery')
      ->setMethods(array('lastUpdatedFirst','findOne','filterByUpdatedAt','find','toArray'))
      ->getMock();
      
    $this->itemQueryFactory->method('createQuery')
      ->will($this->returnValue($this->itemQuery));

    $this->itemQuery->method('lastUpdatedFirst')
      ->will($this->returnValue($this->itemQuery));
    $this->itemQuery->method('select')
      ->will($this->returnValue($this->returnSelf()));
    $this->itemQuery->method('filterByUpdatedAt')
      ->will($this->returnValue($this->returnSelf()));
    $this->itemQuery->method('find')
      ->will($this->returnValue($this->itemQuery));
  }

  public function testGetToDoList()
  {
    $itemMaintenance = new ItemMaintenance($this->itemAssembler, $this->itemQueryFactory);

    //produce the same id list for the 2 different trials
    $idList = array(1,2,3,4,5,6,7,8);//this is the list of ids that the "server" will pass back
    $this->itemAssembler->expects($this->exactly(2))
     ->method('getIdList')
     ->will($this->returnValue($idList));

    //expect different item queries for the 2 trials
    $skipListFull = array(2,4,5,7,8);
    $skipListDate = array(5,7,8);
    $date = DateTime::createFromFormat('m/d/Y','11/04/2000');
    $this->itemQuery->expects($this->exactly(1))
      ->method('filterByUpdatedAt')
      ->withConsecutive(
        array(),
        array($this->equalTo($date)));

    $this->itemQuery->method('toArray')
      ->will($this->onConsecutiveCalls($skipListFull, $skipListDate));

    //first do a test, which excludes all of the results in the database
    $list = $itemMaintenance->getToDoList();
    $toList = array_diff($idList, $skipListFull);
    $this->assertEquals($toList, $list);

    //next do a test which excludes all of the results after a date
    $list2 = $itemMaintenance->getToDoList($date);
    $toList2 = array_diff($idList, $skipListDate);
    $this->assertEquals($toList2, $list2);

    $this->assertNotEquals($toList,$toList2);
  }
  
  public function testGetLastRun()
  {
    $item = $this->getMockBuilder('GW2Exchange\Database\Item')
      ->setMethods(array('getUpdatedAt'))
      ->getMock();

    $itemMaintenance = new ItemMaintenance($this->itemAssembler, $this->itemQueryFactory);

    $date = DateTime::createFromFormat('m/d/Y','11/04/2000');

    $this->itemQuery->method('findOne')
      ->will($this->returnValue($item));

    $item->method('getUpdatedAt')
      ->will($this->returnValue($date->format('Y-m-d H:i:s')));

    //first do a test, which excludes all of the results in the database
    $lastDate = $itemMaintenance->getLastRun();
    $this->assertEquals($date, $lastDate);
  }

  public function testRunMaintenance($ids = array(),$staleDateTime = null)
  {
    $fullList = array(1,2,3,4,5,6,7,8,9,10,11,13,14,15);
    $shortItemIdList = array(1,2,3,4);//this is for all non existing only
    
    $item = $this->getMockBuilder('GW2Exchange\Database\Item')
      ->setMethods(array('save'))
      ->getMock();

    $item->expects($this->exactly(3))
     ->method('save');

    //run 2 tests, one with all non existings asked for, and one with all old+non existing
    $this->itemAssembler->expects($this->exactly(2))
      ->method('getByIds')
      ->withConsecutive(
        array($this->equalTo($shortItemIdList)),
        array($this->equalTo(array_diff($fullList, $shortItemIdList))))
      ->will($this->onConsecutiveCalls(array($item),array($item,$item)));


    $this->itemAssembler
      ->expects($this->exactly(1))
      ->method('getIdList')
      ->will($this->returnValue($fullList));


    $date = DateTime::createFromFormat('m/d/Y','11/04/2000');
    $this->itemQuery->expects($this->exactly(1))
      ->method('filterByUpdatedAt')
      ->with($this->equalTo(array("min"=>$date->format('Y-m-d H:i:s'))));

    $this->itemQuery->expects($this->exactly(1))
      ->method('toArray')
      ->will($this->returnValue($shortItemIdList));//return the list of already done

    $itemMaintenance = new ItemMaintenance($this->itemAssembler, $this->itemQueryFactory);
    //run once with a list of ids
    $itemMaintenance->runMaintenance($shortItemIdList);

    //run once with a date
    $itemMaintenance->runMaintenance(null,$date);
  }
}