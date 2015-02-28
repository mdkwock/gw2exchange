
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
    `id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_info
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_info`;

CREATE TABLE `item_info`
(
    `item_id` INTEGER NOT NULL,
    `item_description` TEXT,
    `item_type` VARCHAR(255) NOT NULL,
    `item_rarity` VARCHAR(255) NOT NULL,
    `item_level` INTEGER NOT NULL,
    `item_vendor_value` INTEGER NOT NULL,
    `item_default_skin` INTEGER,
    `item_flags` VARCHAR(255) NOT NULL,
    `item_game_types` VARCHAR(255) NOT NULL,
    `item_restrictions` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`item_id`),
    CONSTRAINT `item_info_fk_5cf635`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_item_detail
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_item_detail`;

CREATE TABLE `item_item_detail`
(
    `item_id` INTEGER NOT NULL,
    `item_detail_id` INTEGER NOT NULL,
    `value` TEXT,
    PRIMARY KEY (`item_id`,`item_detail_id`),
    INDEX `item_item_detail_fi_831fda` (`item_detail_id`),
    CONSTRAINT `item_item_detail_fk_5cf635`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`id`),
    CONSTRAINT `item_item_detail_fk_831fda`
        FOREIGN KEY (`item_detail_id`)
        REFERENCES `item_detail` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_detail
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_detail`;

CREATE TABLE `item_detail`
(
    `id` INTEGER NOT NULL,
    `item_type` VARCHAR(255) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `value_type` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- listing
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `listing`;

CREATE TABLE `listing`
(
    `id` INTEGER NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `orders` INTEGER NOT NULL,
    `unit_price` INTEGER NOT NULL,
    `quantity` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_summary
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_summary`;

CREATE TABLE `item_summary`
(
    `item_id` INTEGER NOT NULL,
    `buy_price` INTEGER,
    `sell_price` INTEGER,
    `buy_qty` INTEGER,
    `sell_qty` INTEGER,
    PRIMARY KEY (`item_id`),
    CONSTRAINT `item_summary_fk_5cf635`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
