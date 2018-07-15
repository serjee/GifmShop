CREATE DATABASE db_vkitlike DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

/* Пользователи */
DROP TABLE IF EXISTS vkil_users;
CREATE TABLE IF NOT EXISTS vkil_users (
    `uid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User ID',
    `vk_uid` INT(10) UNSIGNED NOT NULL COMMENT 'VK User ID',
    `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'User Name',
    `status` ENUM('SET','DEL','NON') NOT NULL DEFAULT 'NON' COMMENT 'User Status',
    `time_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Setup time',
    `time_update` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last update time',
    PRIMARY KEY (`uid`),
    UNIQUE `vk_uid` (`vk_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Категории товаров */
DROP TABLE IF EXISTS vkil_items_category;
CREATE TABLE IF NOT EXISTS vkil_items_category (
  `cid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Item ID',
  `parent_id` INT(10) UNSIGNED NOT NULL COMMENT 'XML Item ID',
  `name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Category Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Товары */
DROP TABLE IF EXISTS vkil_items;
CREATE TABLE IF NOT EXISTS vkil_items (
  `iid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Item ID',
  `xml_id` INT(10) UNSIGNED NOT NULL COMMENT 'XML Item ID',
  `category_id` INT(10) UNSIGNED NOT NULL COMMENT 'Category Item ID',
  `active` ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Item Status',
  `articul` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'Item Articul',
  `title` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Item Name',
  `description` TEXT NOT NULL DEFAULT '' COMMENT 'Item Description',
  `image` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Item Url Image',
  `url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Item Url',
  `price_votes` INT(10) UNSIGNED NOT NULL COMMENT 'Price in Votes',
  `time_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Setup time',
  `time_update` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last update time',
  PRIMARY KEY (`iid`),
  UNIQUE `xml_id` (`xml_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `vkil_items_category` (`cid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Копилки (объявленный сбор на подарок) */
DROP TABLE IF EXISTS vkil_gifts;
CREATE TABLE vkil_gifts (
    `gid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `owner_id` INT(10) UNSIGNED NOT NULL COMMENT 'Owner User ID',
    `user_gift_id` INT(10) UNSIGNED NOT NULL COMMENT 'Gift User ID',
    `item_gift_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Item Gift ID',
    `cur_votes` INT(10) UNSIGNED NOT NULL COMMENT 'Current Gift Votes',
    `need_votes` INT(10) UNSIGNED NOT NULL COMMENT 'Need Gift Votes',
    `title` VARCHAR(80) NOT NULL DEFAULT '' COMMENT 'Title for Gift (76max)',
    `description` TEXT NOT NULL DEFAULT '' COMMENT 'About Gift',
    `status` ENUM('ACTIVE','CLOSED','SUCCESS','DELIVERED') NOT NULL DEFAULT 'ACTIVE' COMMENT 'Gift Status',
    `time_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Create time',
    `time_update` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last edit time',
    `time_end` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End time of gift',
    PRIMARY KEY (`gid`),
    CONSTRAINT `user_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `vkil_users` (`uid`) ON DELETE CASCADE,
    CONSTRAINT `user_gifts_id` FOREIGN KEY (`user_gift_id`) REFERENCES `vkil_users` (`uid`) ON DELETE CASCADE,
    CONSTRAINT `item_gifts_id` FOREIGN KEY (`item_gift_id`) REFERENCES `vkil_items` (`iid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Участники сбора на подарок (транзакции) */
DROP TABLE IF EXISTS vkil_gifts_members;
CREATE TABLE vkil_gifts_members (
  `mid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'Owner User ID',
  `gift_id` INT(10) UNSIGNED NOT NULL COMMENT 'Gift User ID',
  `pay_votes` INT(10) UNSIGNED NOT NULL COMMENT 'Item Gift ID',
  `status` ENUM('PAYED','REFUND') NOT NULL DEFAULT 'PAYED' COMMENT 'Pay Status',
  `time_pay` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Datetime',
  PRIMARY KEY (`mid`),
  CONSTRAINT `user_member_id` FOREIGN KEY (`user_id`) REFERENCES `vkil_users` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `item_gifts_id` FOREIGN KEY (`gift_id`) REFERENCES `vkil_gifts` (`gid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Поздравления участников */
DROP TABLE IF EXISTS vkil_gifts_wishes;
CREATE TABLE vkil_gifts_wishes (
  `wid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'Owner User ID',
  `gift_id` INT(10) UNSIGNED NOT NULL COMMENT 'Gift User ID',
  `wish` TEXT NOT NULL DEFAULT '' COMMENT 'Wish for User',
  `time_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Datetime',
  PRIMARY KEY (`wid`),
  CONSTRAINT `user_member_id` FOREIGN KEY (`user_id`) REFERENCES `vkil_users` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `item_gifts_id` FOREIGN KEY (`gift_id`) REFERENCES `vkil_gifts` (`gid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;