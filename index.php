<?php
require './vendor/autoload.php';
use GW2ledger\GuzzleWebScraper;
use Monolog\Handler\AmqpHandler;
$str = '{"name":"MONSTER ONLY Moa Unarmed Pet","type":"Weapon","level":0,"rarity":"Fine","vendor_value":0,"default_skin":3265,"game_types":["Activity","Dungeon","Pve","Wvw"],"flags":["NoSell","SoulbindOnAcquire","SoulBindOnUse"],"restrictions":[],"id":1,"icon":"https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png","details":{"type":"Staff","damage_type":"Physical","min_power":146,"max_power":165,"defense":0,"infusion_slots":[],"infix_upgrade":{"attributes":[]},"secondary_suffix_item_id":""}}';
$json = json_decode($str);
var_export($json);
die();
d(__DIR__);
var_dump(class_exists('Monolog\Handler\AmqpHandler'));
var_dump(class_exists('GW2ledger\GuzzleWebScraper'));
require __DIR__.'/src/GuzzleWebScraper.php';
use GuzzleHttp\Client;
$a = new AmqpHandler();
$client = new Client();

$response = $client->get('http://httpbin.org/get');
d($response);
var_dump(class_exists('GuzzleHttp\Client'));
new GuzzleWebScraper();


?>