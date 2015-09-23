<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1443145431.
 * Generated on 2015-09-24 21:43:51 by vagrant
 */
class PropelMigration_1443145431
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'gw2exchange' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `item`

  CHANGE `hash` `hash` VARCHAR(3000) NOT NULL;

ALTER TABLE `listing`

  CHANGE `item_id` `item_id` INTEGER NOT NULL;

ALTER TABLE `price`

  CHANGE `buy_price` `buy_price` INTEGER NOT NULL,

  CHANGE `sell_price` `sell_price` INTEGER NOT NULL,

  CHANGE `buy_qty` `buy_qty` INTEGER NOT NULL,

  CHANGE `sell_qty` `sell_qty` INTEGER NOT NULL,

  CHANGE `hash` `hash` VARCHAR(128) NOT NULL,

  CHANGE `cache_time` `cache_time` INTEGER DEFAULT 4;

ALTER TABLE `price_history`

  CHANGE `item_id` `item_id` INTEGER NOT NULL,

  CHANGE `buy_price` `buy_price` INTEGER NOT NULL,

  CHANGE `sell_price` `sell_price` INTEGER NOT NULL,

  CHANGE `buy_qty` `buy_qty` INTEGER NOT NULL,

  CHANGE `sell_qty` `sell_qty` INTEGER NOT NULL,

  CHANGE `hash` `hash` VARCHAR(128) NOT NULL;

ALTER TABLE `requests_log` DROP FOREIGN KEY `requests_log_fk_5cf635`;

DROP INDEX `requests_log_fi_5cf635` ON `requests_log`;

ALTER TABLE `requests_log`

  CHANGE `item_id` `cache_correct` INTEGER,

  CHANGE `url` `url` INTEGER NOT NULL,

  CHANGE `gw2ServerUrl` `gw2ServerUrl` INTEGER NOT NULL,

  CHANGE `cache_hit` `cache_hit` INTEGER NOT NULL,

  ADD `price_history_id` INTEGER NOT NULL AFTER `gw2ServerUrl`;

CREATE INDEX `requests_log_fi_968063` ON `requests_log` (`price_history_id`);

ALTER TABLE `requests_log` ADD CONSTRAINT `requests_log_fk_968063`
    FOREIGN KEY (`price_history_id`)
    REFERENCES `price_history` (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'gw2exchange' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `item`

  CHANGE `hash` `hash` VARCHAR(255) NOT NULL;

ALTER TABLE `listing`

  CHANGE `item_id` `item_id` INTEGER;

ALTER TABLE `price`

  CHANGE `buy_price` `buy_price` INTEGER,

  CHANGE `sell_price` `sell_price` INTEGER,

  CHANGE `buy_qty` `buy_qty` INTEGER,

  CHANGE `sell_qty` `sell_qty` INTEGER,

  CHANGE `hash` `hash` VARCHAR(128),

  CHANGE `cache_time` `cache_time` INTEGER DEFAULT 1;

ALTER TABLE `price_history`

  CHANGE `item_id` `item_id` INTEGER,

  CHANGE `buy_price` `buy_price` INTEGER,

  CHANGE `sell_price` `sell_price` INTEGER,

  CHANGE `buy_qty` `buy_qty` INTEGER,

  CHANGE `sell_qty` `sell_qty` INTEGER,

  CHANGE `hash` `hash` VARCHAR(128);

ALTER TABLE `requests_log` DROP FOREIGN KEY `requests_log_fk_968063`;

DROP INDEX `requests_log_fi_968063` ON `requests_log`;

ALTER TABLE `requests_log`

  CHANGE `cache_correct` `item_id` INTEGER,

  CHANGE `url` `url` INTEGER,

  CHANGE `gw2ServerUrl` `gw2ServerUrl` INTEGER,

  CHANGE `cache_hit` `cache_hit` INTEGER,

  DROP `price_history_id`;

CREATE INDEX `requests_log_fi_5cf635` ON `requests_log` (`item_id`);

ALTER TABLE `requests_log` ADD CONSTRAINT `requests_log_fk_5cf635`
    FOREIGN KEY (`item_id`)
    REFERENCES `item` (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}