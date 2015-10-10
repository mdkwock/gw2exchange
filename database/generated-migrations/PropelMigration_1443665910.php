<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1443665910.
 * Generated on 2015-09-30 22:18:30 by vagrant
 */
class PropelMigration_1443665910
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

DROP TABLE IF EXISTS `requests_log`;

CREATE TABLE `price_request_log_entry`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `url` INTEGER NOT NULL,
    `gw2_server_url` INTEGER NOT NULL,
    `price_history_id` INTEGER NOT NULL,
    `cache_hit` INTEGER NOT NULL,
    `cache_correct` INTEGER,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `price_request_log_entry_fi_968063` (`price_history_id`),
    CONSTRAINT `price_request_log_entry_fk_968063`
        FOREIGN KEY (`price_history_id`)
        REFERENCES `price_history` (`id`)
) ENGINE=InnoDB;

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

DROP TABLE IF EXISTS `price_request_log_entry`;

CREATE TABLE `requests_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `url` INTEGER NOT NULL,
    `gw2ServerUrl` INTEGER NOT NULL,
    `price_history_id` INTEGER NOT NULL,
    `cache_correct` INTEGER,
    `cache_hit` INTEGER NOT NULL,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `requests_log_fi_968063` (`price_history_id`),
    CONSTRAINT `requests_log_fk_968063`
        FOREIGN KEY (`price_history_id`)
        REFERENCES `price_history` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}