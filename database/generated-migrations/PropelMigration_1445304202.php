<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1445304202.
 * Generated on 2015-10-19 21:23:22 by vagrant
 */
class PropelMigration_1445304202
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

ALTER TABLE `price_request_log_entry`

  CHANGE `cache_hit` `cache_hit` TINYINT(1) NOT NULL,

  CHANGE `cache_correct` `cache_correct` TINYINT(1);

ALTER TABLE `price_update_check_log_entry`

  CHANGE `is_modified` `is_modified` TINYINT(1) NOT NULL;

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

ALTER TABLE `price_request_log_entry`

  CHANGE `cache_hit` `cache_hit` INTEGER NOT NULL,

  CHANGE `cache_correct` `cache_correct` INTEGER;

ALTER TABLE `price_update_check_log_entry`

  CHANGE `is_modified` `is_modified` INTEGER NOT NULL;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}