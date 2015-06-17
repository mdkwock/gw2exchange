<?php
use \GW2Exchange\Maintenance\ListingMaintenance;

use GW2Exchange\Listing\ListingAssembler;
use GW2Exchange\Database\ListingQueryFactory;
use GW2Exchange\Database\ItemQueryFactory;
use GW2Exchange\Database\ListingQuery;
use GW2Exchange\Database\Listing;

class ListingMaintenanceTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){
    $this->listingAssembler = $this->getMockBuilder('GW2Exchange\Listing\ListingAssembler')
      ->disableOriginalConstructor()
      ->setMethods(array('getIdList','getByItemIds'))
      ->getMock();

    $this->listingQueryFactory =  $this->getMockBuilder('GW2Exchange\Database\ListingQueryFactory')
      ->setMethods(array('createQuery'))
      ->getMock();
      
    $this->listingQuery =  $this->getMockBuilder('GW2Exchange\Database\ListingQuery')
      ->setMethods(array('lastUpdatedFirst','findOne','filterByUpdatedAt','find','toArray'))
      ->getMock();

    $this->itemQueryFactory =  $this->getMockBuilder('GW2Exchange\Database\ItemQueryFactory')
      ->setMethods(array('lastUpdatedFirst','findOne','filterByUpdatedAt','find','toArray'))
      ->getMock();
      
    $this->listingQueryFactory->method('createQuery')
      ->will($this->returnValue($this->listingQuery));

    $this->listingQuery->method('lastUpdatedFirst')
      ->will($this->returnValue($this->listingQuery));
    $this->listingQuery->method('select')
      ->will($this->returnValue($this->returnSelf()));
    $this->listingQuery->method('filterByUpdatedAt')
      ->will($this->returnValue($this->returnSelf()));
    $this->listingQuery->method('find')
      ->will($this->returnValue($this->listingQuery));
  }

  public function testGetToDoList()
  {
    $listingMaintenance = new ListingMaintenance($this->listingAssembler, $this->listingQueryFactory, $this->itemQueryFactory);

    //produce the same id list for the 2 different trials
    $idList = array(1,2,3,4,5,6,7,8);//this is the list of ids that the "server" will pass back
    $this->listingAssembler->expects($this->exactly(2))
     ->method('getIdList')
     ->will($this->returnValue($idList));

    //expect different listing queries for the 2 trials
    $skipListFull = array(2,4,5,7,8);
    $skipListDate = array(5,7,8);
    $date = DateTime::createFromFormat('m/d/Y','11/04/2000');
    $this->listingQuery->expects($this->exactly(1))
      ->method('filterByUpdatedAt')
      ->withConsecutive(
        array(),
        array($this->equalTo($date)));

    $this->listingQuery->method('toArray')
      ->will($this->onConsecutiveCalls($skipListFull, $skipListDate));

    //first do a test, which excludes all of the results in the database
    $list = $listingMaintenance->getToDoList();
    $toList = array_diff($idList, $skipListFull);
    $this->assertEquals($toList, $list);

    //next do a test which excludes all of the results after a date
    $list2 = $listingMaintenance->getToDoList($date);
    $toList2 = array_diff($idList, $skipListDate);
    $this->assertEquals($toList2, $list2);

    $this->assertNotEquals($toList,$toList2);
  }
  
  public function testGetLastRun()
  {
    $listing = $this->getMockBuilder('GW2Exchange\Database\Listing')
      ->setMethods(array('getUpdatedAt'))
      ->getMock();

    $listingMaintenance = new ListingMaintenance($this->listingAssembler, $this->listingQueryFactory, $this->itemQueryFactory);

    $date = DateTime::createFromFormat('m/d/Y','11/04/2000');

    $this->listingQuery->method('findOne')
      ->will($this->returnValue($listing));

    $listing->method('getUpdatedAt')
      ->will($this->returnValue($date->format('Y-m-d H:i:s')));

    //first do a test, which excludes all of the results in the database
    $lastDate = $listingMaintenance->getLastRun();
    $this->assertEquals($date, $lastDate);
  }

  public function testRunMaintenance($ids = array(),$staleDateTime = null)
  {
    $shortListingIdList = array(1,2,3,4);//this is for all non existing only
    $fullListingList = array(1,2,3,4,5,6,7);//this is for all non existing and all old
    
    $listing = $this->getMockBuilder('GW2Exchange\Database\Listing')
      ->setMethods(array('save'))
      ->getMock();

    $listing->expects($this->exactly(3))
     ->method('save');

    //run 2 tests, one with all non existings asked for, and one with all old+non existing
    $this->listingAssembler->expects($this->exactly(2))
      ->method('getByItemIds')
      ->withConsecutive(
        array($this->equalTo($shortListingIdList)),
        array($this->equalTo(array_diff($fullListingList, $shortListingIdList))))
      ->will($this->onConsecutiveCalls(array($listing),array($listing,$listing)));


    $this->listingAssembler->expects($this->exactly(1))
      ->method('getIdList')
      ->will($this->returnValue($fullListingList));


    $date = DateTime::createFromFormat('m/d/Y','11/04/2000');
    $this->listingQuery->expects($this->exactly(1))
      ->method('filterByUpdatedAt')
      ->with($this->equalTo(array("min"=>$date->format('Y-m-d H:i:s'))));

    $this->listingQuery->expects($this->exactly(1))
      ->method('toArray')
      ->will($this->returnValue($shortListingIdList));//return the list of already done

    $listingMaintenance = new ListingMaintenance($this->listingAssembler, $this->listingQueryFactory, $this->itemQueryFactory);
    //run once with a list of ids
    $listingMaintenance->runMaintenance($shortListingIdList);

    //run once with a date
    $listingMaintenance->runMaintenance(null,$date);
  }
}