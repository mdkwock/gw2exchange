<?php

use GW2Exchange\Connection\GuzzleWebScraper;

use GuzzleHttp\Client;
use GuzzleHttp\Message\AbstractMessage;

class GuzzleWebScraperTest extends PHPUnit_Framework_TestCase
{
    public function testGetInfo()
    {
        $url = "https://api.guildwars2.com/";//this has a very simple result
        $answer = '["v1"]';

        $response = $this->getMockBuilder('GuzzleHttp\Message\AbstractMessage')
                        //->setConstructorArgs(array('404',array(),null,array()))
                        ->setMethods(array('getBody'))
                        ->getMock();
        $response->method('getBody')
            ->will($this->returnValue($answer));

        $client = $this->getMockBuilder('GuzzleHttp\Client')
                         ->setMethods(array('get'))
                         ->getMock();
        $client->method('get')
            ->will($this->returnValue($response));

        $webScraper = new GuzzleWebScraper($client);
        $this->assertNotEmpty($webScraper);
        $result = $webScraper->getInfo($url);
        $this->assertNotEmpty($result);
        $this->assertEquals($answer,$result);
    }
}
?>