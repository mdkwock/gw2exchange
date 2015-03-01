<?php
require './vendor/autoload.php';
use GW2ledger\GuzzleWebScraper;
use Monolog\Handler\AmqpHandler;
$str = '';
$json = json_decode($str,true);
var_export($json);
$item = array(
  "name"=>,
  "icon"=>,
);
$item_info = array(
  "item_description"=>,
  "item_type"=>,
  "item_rarity"=>,
  "item_level"=>,
  "item_vendor_value"=>,
  "item_default_skin"=>,
  "item_flags"=>,
  "item_game_types"=>,
  "item_restrictions"=>,
);

  <!--
    A table which links the item to the item detail
  -->
  <table name="item_item_detail" isCrossRef="true">
    <column name="item_id" type="integer" required="required" primaryKey="true"/>
    <column name="item_detail_id" type="integer" required="required" primaryKey="true"/>
    <column name="value" type="LONGVARCHAR"/>
    <foreign-key foreignTable="item">
      <reference local="item_id" foreign="id"/>
    </foreign-key>
    <foreign-key foreignTable="item_detail">
      <reference local="item_detail_id" foreign="id"/>
    </foreign-key>
  </table>

  <!--
    The Item's detail, it varies based on the item's type
    this table will most likely not change very often, because it is all of the attributes that
    GW decides to add into the game
  -->
  <table name="item_detail">
    <column name="id" type="integer" primaryKey="true"/>   
    <column name="item_type" type="varchar" size="255" required="true" />
    <!-- what the item detail is called -->
    <column name="label" type="varchar" size="255" required="true" />
    <!-- the variable type ex number, string, array not sure if this will be used -->
    <column name="value_type" type="varchar" size="255" required="true" />    
  </table>

  <table name="listing">
    <column name="id" type="integer" primaryKey="true"/>   
    <!-- Type is either buy or sell for the type of order -->
    <column name="type" type="varchar" required="true"/> 
    <!-- The number of individual listings this object refers to (e.g. two players selling at the same price will end up in the same listing) -->
    <column name="orders" type="integer" required="true"/> 
    <column name="unit_price" type="integer" required="true"/> 
    <column name="quantity" type="integer" required="true"/> 
  </table>
    <!-- 
      This table has the information that would be visible from the trading place's screen.
      So it shows the highest buy and lowest sell along with qtys.
      It's to be used as a quick survey over every item when scanning, rather than load each ones' details
     -->
  <table name="item_summary">
    <!-- setting primary key to true, makes propel treat it as a 1-1 relation -->
    <column name="item_id" type="integer" required="required" primaryKey="true" />
    <column name="buy_price" type="integer" required="required" />
    <column name="sell_price" type="integer" required="required" />
    <column name="buy_qty" type="integer" required="required" />
    <column name="sell_qty" type="integer" required="required" />
    <foreign-key foreignTable="item">
      <reference local="item_id" foreign="id"/>
    </foreign-key>
  </table>
</database>

array ( 
  'name' => 'MONSTER ONLY Moa Unarmed Pet',
  'type' => 'Weapon', 
  'level' => 0,
  'rarity' => 'Fine',
  'vendor_value' => 0,
  'default_skin' => 3265,
  'game_types' => array (
    0 => 'Activity',
    1 => 'Dungeon',
    2 => 'Pve',
    3 => 'Wvw',
  ),
  'flags' => array (
    0 => 'NoSell',
    1 => 'SoulbindOnAcquire',
    2 => 'SoulBindOnUse',
  ),
  'restrictions' => array ( ),
  'id' => 1,
  'icon' => 'https://render.guildwars2.com/file/4AECE5EA59CA057F4C53E1EDFE95E0E3E61DE37F/60980.png',
  'details' => array (
    'type' => 'Staff',
    'damage_type' => 'Physical',
    'min_power' => 146,
    'max_power' => 165,
    'defense' => 0,
    'infusion_slots' => array ( ),
    'infix_upgrade' => array (
      'attributes' => array ( ),
    ),
    'secondary_suffix_item_id' => '', 
  ),
);
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