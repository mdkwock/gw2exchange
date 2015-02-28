<?php

use GW2ledger\Connection\GuzzleWebScraper;

use GuzzleHttp\Client;

class GuzzleWebScraperTest extends PHPUnit_Framework_TestCase
{
    public function testGetInfo()
    {
        $url = "https://api.guildwars2.com/";//this has a very simple result
        $webScraper = new GuzzleWebScraper();
        $this->assertNotEmpty($webScraper);
        $result = $webScraper->getInfo($url);
        $this->assertNotEmpty($result);
        $this->assertEquals('["v1","v2"]',$result);
    }
}
?>