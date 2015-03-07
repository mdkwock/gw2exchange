<?php
require './vendor/autoload.php';

require './database/generated-conf/config.php';


use GW2ledger\Item\ItemDetailsArrayObject;


    $details = array (
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
    $type = "Weapon";
    $item = null;
    $itemDetails = new ItemDetailsArrayObject($item, $type, $details);