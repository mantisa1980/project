DROP DATABASE IF EXISTS `car`;
CREATE DATABASE `car`;
use `car`;

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `user` (
    `account` varchar(128) NOT NULL PRIMARY KEY,
    `password` varchar(128) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `groups` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(64) NOT NULL,
    UNIQUE KEY (name)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `groups` ADD INDEX (`name`);

-- ==================================================================================================
-- ==================================================================================================

-- note : INT = 4 BYTEs
-- note: put a space after double dash for comment --. do not use --- , will cause syntax error 

CREATE TABLE `customer` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(64) NOT NULL,
    `company` varchar(128) NOT NULL,
    `vat` varchar(16) NOT NULL,
    `address` varchar(256),
    `phone` varchar(16),
    `cellphone` varchar(16),
    `cellphone2` varchar(16),
    `email` varchar(128),
    `created_on` DATETIME NOT NULL,
    `group_id` INT UNSIGNED NOT NULL,
    
    CONSTRAINT `fk_customer__group_id` FOREIGN KEY (group_id)
        REFERENCES groups (id)
--        ON DELETE SET 1
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `customer` ADD INDEX (`name`);

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `sell_order` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `paid` INT UNSIGNED NOT NULL,
--    `status` INT UNSIGNED NOT NULL DEFAULT 0,  -- 0 = not complete, 1 = complete
    `created_on` DATETIME NOT NULL,
    `note` text,
    `customer_id` INT UNSIGNED NOT NULL,

--    note: log should not be deleted ... 
    CONSTRAINT `fk_sell_order__customer_id` FOREIGN KEY (customer_id) 
        REFERENCES customer (id)
        ON DELETE CASCADE

) ENGINE = InnoDB DEFAULT CHARSET=utf8;
-- ALTER TABLE `sell_order` ADD INDEX (`status`);

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `buy_order` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `paid` INT UNSIGNED NOT NULL,
--    `status` INT UNSIGNED NOT NULL DEFAULT 0,  -- 0 = not complete, 1 = complete
    `created_on` DATETIME NOT NULL,
    `note` text,
    `customer_id` INT UNSIGNED NOT NULL,

    CONSTRAINT `fk_buy_order__customer_id` FOREIGN KEY (customer_id) 
        REFERENCES customer (id)
        ON DELETE CASCADE

) ENGINE = InnoDB DEFAULT CHARSET=utf8;
-- ALTER TABLE `buy_order` ADD INDEX (`status`);

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `item` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(128) NOT NULL,
    UNIQUE KEY (name)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
-- ALTER TABLE `item` ADD INDEX (`name`);

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `unit` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(32) NOT NULL,
    UNIQUE KEY(`name`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `unit` ADD INDEX (`name`);

-- ==================================================================================================
-- ==================================================================================================


CREATE TABLE `sell_order_item` (
    `order_id` INT UNSIGNED NOT NULL,
    `item_id` INT UNSIGNED NOT NULL,
    `unit_id` INT UNSIGNED NOT NULL,
    `unit_amount` INT UNSIGNED NOT NULL,
    `final_per_unit_price` INT UNSIGNED NOT NULL,
    
    -- PRIMARY KEY (order_id, item_id,unit_id),

    CONSTRAINT `fk_sell_order_item__order_id` FOREIGN KEY (order_id) 
        REFERENCES sell_order (id)
        ON DELETE CASCADE,

    CONSTRAINT `fk_sell_order_item__item_id` FOREIGN KEY (item_id) 
        REFERENCES item (id)
        ON DELETE CASCADE,
    CONSTRAINT `fk_sell_order_item__unit_id` FOREIGN KEY (unit_id) 
        REFERENCES unit (id)
        ON DELETE CASCADE
    --    note: log should not be deleted ...
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `buy_order_item` (
    `order_id` INT UNSIGNED NOT NULL,
    `item_id` INT UNSIGNED NOT NULL,
    `unit_id` INT UNSIGNED NOT NULL,
    `unit_amount` INT UNSIGNED NOT NULL,
    `final_per_unit_price` INT UNSIGNED NOT NULL,
    
    -- PRIMARY KEY (order_id, item_id,unit_id),

    CONSTRAINT `fk_buy_order_item__order_id` FOREIGN KEY (order_id) 
        REFERENCES buy_order (id)
        ON DELETE CASCADE,

    CONSTRAINT `fk_buy_order_item__item_id` FOREIGN KEY (item_id) 
        REFERENCES item (id)
        ON DELETE CASCADE,
    CONSTRAINT `fk_buy_order_item__unit_id` FOREIGN KEY (unit_id) 
        REFERENCES unit (id)
        ON DELETE CASCADE
    --    note: log should not be deleted ...
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ==================================================================================================
-- ==================================================================================================

CREATE TABLE `price` (
    `group_id` INT UNSIGNED NOT NULL,
    CONSTRAINT `fk_group_price__group_id` FOREIGN KEY (group_id) 
        REFERENCES groups (id)
        ON DELETE CASCADE,

    `item_id` INT UNSIGNED NOT NULL,
    CONSTRAINT `fk_group_price__item_id` FOREIGN KEY (item_id) 
        REFERENCES item (id)
        ON DELETE CASCADE,

    `unit_id` INT UNSIGNED NOT NULL,
    CONSTRAINT `fk_group_price__unit_id` FOREIGN KEY (unit_id) 
        REFERENCES unit (id)
        ON DELETE CASCADE,
    `buy_price` INT UNSIGNED NOT NULL DEFAULT 0,
    `sell_price` INT UNSIGNED NOT NULL DEFAULT 0,

     PRIMARY KEY (group_id, item_id,unit_id)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- ==================================================================================================
-- ==================================================================================================

INSERT INTO `user` (`account`, `password`) VALUES ('admin', '1qaz2wsx3edc4rfv');

INSERT INTO `groups` (`name`) VALUES ('預設群組');
INSERT INTO `item` (`name`) VALUES ('預設品項');
INSERT INTO `unit` (`name`) VALUES ('預設單位');
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price`, `sell_price`)
    VALUES ( (SELECT id from groups)  , (SELECT id from item) , (SELECT id from unit), 0,0 );