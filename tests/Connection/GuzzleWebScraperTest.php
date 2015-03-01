<?php

use GW2ledger\Connection\GuzzleWebScraper;

class GuzzleWebScraperTest extends PHPUnit_Framework_TestCase
{
    public function testGetInfo()
    {
        $url = "https://api.guildwars2.com/";//this has a very simple result
        $answer = '["v1","v2"]';
        $webScraper = new GuzzleWebScraper();
        $this->assertNotEmpty($webScraper);
        $result = $webScraper->getInfo($url);
        $this->assertNotEmpty($result);
        $this->assertEquals($answer,$result);
    }
}
?>