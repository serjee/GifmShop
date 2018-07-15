CREATE DATABASE db_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS yii_user;
CREATE TABLE IF NOT EXISTS yii_user (
    `uid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `email` VARCHAR(50) NOT NULL COMMENT 'E-mail',
    `password` CHAR(32) NOT NULL COMMENT 'Пароль',
    `salt` CHAR(32) NOT NULL COMMENT 'Код безопасности',
    `role` ENUM('ADMIN','MODERATOR','PARTNER','USER') NOT NULL DEFAULT 'USER' COMMENT 'Роль',
    `time_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания',
    `time_update` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Время входа',
    `enabled` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Активность (0-нет, 1-да)',
    `ip` VARCHAR(15) NOT NULL DEFAULT '0' COMMENT 'IP адрес',
    PRIMARY KEY (`uid`),
    UNIQUE `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO yii_user (`email`, `password`, `salt`, `role`) VALUES ('admin@gifm.ru','b8da40bf357e3de6cf0f9570c7cff2c0','4ff0449a4a31e7.87066262','ADMIN'); /* Password: demo */

DROP TABLE IF EXISTS yii_profile;
CREATE TABLE yii_profile (
    `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'User ID',
    `firstname` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'First Name',
    `lastname` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Last Name',
    `uimage` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'User Photo',
    `about` TEXT NOT NULL DEFAULT '' COMMENT 'User About',
    UNIQUE KEY `user_id` (`user_id`),
    CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `yii_user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO yii_profile (`user_id`) VALUES ('1');

/* Таблица для хранения пользовательских профилей доставки (изменяемых пользователем) */
DROP TABLE IF EXISTS yii_orders_address;
CREATE TABLE yii_orders_address (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'ID Пользователя',
  `zip_code` INT(7) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Индекс',
  `country_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Страна',
  `city` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Город',
  `address` TEXT NOT NULL DEFAULT '' COMMENT 'Адрес',
  `comments` TEXT NOT NULL DEFAULT '' COMMENT 'Комментарий',
  `recipient` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'Получатель',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Таблица для хранения адресов доставки заказов (не изменяемых после оформлении заказа) */
DROP TABLE IF EXISTS yii_orders_delivery;
CREATE TABLE yii_orders_delivery (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'ID Пользователя',
  `zip_code` INT(7) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Индекс',
  `country_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Страна',
  `city` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Город',
  `address` TEXT NOT NULL DEFAULT '' COMMENT 'Адрес',
  `comments` TEXT NOT NULL DEFAULT '' COMMENT 'Комментарий',
  `recipient` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'Получатель',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS yii_orders;
CREATE TABLE yii_orders (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'ID Пользователя',
  `profile_id` INT(10) UNSIGNED NOT NULL COMMENT 'Профиль доставки',
  `price` DECIMAL(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Цена',
  `currency` ENUM('RUB','USD','EUR') NOT NULL DEFAULT 'RUB' COMMENT 'Валюта',
  `category_id` SMALLINT(5) NOT NULL DEFAULT '0' COMMENT 'Категория',
  `whom` ENUM('ALL','MAN','WOMAN','CHILDBOY','CHILDGIRL') NOT NULL DEFAULT 'ALL' COMMENT 'Кому',
  `age` TINYINT(2) NOT NULL DEFAULT '0' COMMENT 'Возраст',
  `hobbies` TEXT NOT NULL DEFAULT '' COMMENT 'Увлечения',
  `about` TEXT NOT NULL DEFAULT '' COMMENT 'О себе',
  `message` TEXT NOT NULL DEFAULT '' COMMENT 'Открытка',
  `prize_from` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'От кого',
  `status` ENUM('NEW','PROCESS','PAYED','SHIPPING','SENT','DONE','CANCELED','DELETED') NOT NULL,
  `mail_id` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'Почтовый ID',
  `msg_to_user` TEXT NOT NULL DEFAULT '' COMMENT 'Сообщение пользователю',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `profile_id` (`profile_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS yii_orders_temp;
CREATE TABLE yii_orders_temp (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_hash` CHAR(32) NOT NULL COMMENT 'Код безопасности',
  `step_num` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Шаг',
  `price` DECIMAL(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Цена',
  `currency` ENUM('RUB','USD','EUR') NOT NULL DEFAULT 'RUB' COMMENT 'Валюта',
  `category_id` SMALLINT(5) NOT NULL DEFAULT '0' COMMENT 'Категория',
  `whom` ENUM('ALL','MAN','WOMAN','CHILDBOY','CHILDGIRL') NOT NULL DEFAULT 'ALL' COMMENT 'Кому',
  `age` TINYINT(2) NOT NULL DEFAULT '0' COMMENT 'Возраст',
  `hobbies` TEXT NOT NULL DEFAULT '' COMMENT 'Увлечения',
  `about` TEXT NOT NULL DEFAULT '' COMMENT 'О себе',
  `message` TEXT NOT NULL DEFAULT '' COMMENT 'Открытка',
  `prize_from` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'От кого',
  `profile_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Профиль доставки',
  `zip_code` INT(7) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Индекс',
  `country_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Страна',
  `city` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Город',
  `address` TEXT NOT NULL DEFAULT '' COMMENT 'Адрес',
  `comments` TEXT NOT NULL DEFAULT '' COMMENT 'Комментарий',
  `recipient` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'Получатель',
  `email` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'E-mail',
  `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Имя',
  `phone` VARCHAR(20) NOT NULL DEFAULT '' COMMENT 'Телефон',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_hash` (`order_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `yii_logpayment`;
CREATE TABLE IF NOT EXISTS `yii_logpayment` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` INT(11) UNSIGNED NOT NULL COMMENT 'ID пользователя',
  `order_id` INT(11) UNSIGNED NOT NULL COMMENT 'ID заказа',
  `pin_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'ID пин-кода',
  `amount` DECIMAL(10,2) NOT NULL COMMENT 'Сумма',
  `currency` ENUM('RUB','USD','EUR') NOT NULL DEFAULT 'RUB' COMMENT 'Валюта',
  `in_out` ENUM('IN','OUT') NOT NULL COMMENT 'In or Out transaction',
  `pay_system` ENUM('WMR','WMZ','YAM','QIWI','PAYPAL','ROBOX','NAL','PIN') NOT NULL COMMENT 'Pay System',
  `payed_type` ENUM('AUTO','MAN') NOT NULL COMMENT 'Payed Type',
  `state` ENUM('I','P','R','S','F') NOT NULL DEFAULT 'I',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time',
  `lmi_sys_invs_no` INT(11) DEFAULT NULL,
  `lmi_sys_trans_no` INT(11)  DEFAULT NULL,
  `lmi_sys_trans_date` DATETIME DEFAULT NULL,
  `lmi_payer_purse` VARCHAR(20) DEFAULT NULL,
  `lmi_payer_wm` VARCHAR(20) DEFAULT NULL,
  `lmi_sys_payment_id` VARCHAR(255) DEFAULT NULL,
  `lmi_sys_payment_date` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `pin_id` (`pin_id`),
  KEY `pay_system` (`pay_system`),
  KEY `state` (`state`),
  KEY `i_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS yii_prices;
CREATE TABLE yii_prices (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `price_ru` DECIMAL(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Цена RUB',
  `price_us` DECIMAL(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Цена USD',
  `price_eu` DECIMAL(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Цена EUR',
  `sort_id` INT(10) UNSIGNED NOT NULL DEFAULT '500' COMMENT 'Сортировка',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO yii_prices (`price_ru`) VALUES ('98');
INSERT INTO yii_prices (`price_ru`) VALUES ('189');
INSERT INTO yii_prices (`price_ru`) VALUES ('289');
INSERT INTO yii_prices (`price_ru`) VALUES ('489');
INSERT INTO yii_prices (`price_ru`) VALUES ('749');
INSERT INTO yii_prices (`price_ru`) VALUES ('989');
INSERT INTO yii_prices (`price_ru`) VALUES ('1500');
INSERT INTO yii_prices (`price_ru`) VALUES ('2000');
INSERT INTO yii_prices (`price_ru`) VALUES ('3000');
INSERT INTO yii_prices (`price_ru`) VALUES ('5000');
INSERT INTO yii_prices (`price_ru`) VALUES ('7500');
INSERT INTO yii_prices (`price_ru`) VALUES ('10000');
INSERT INTO yii_prices (`price_ru`) VALUES ('15000');
INSERT INTO yii_prices (`price_ru`) VALUES ('20000');
INSERT INTO yii_prices (`price_ru`) VALUES ('30000');

DROP TABLE IF EXISTS yii_categories;
CREATE TABLE yii_categories (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ru` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Название русское',
  `name_en` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Название английское',
  `sort_id` INT(10) UNSIGNED NOT NULL DEFAULT '500' COMMENT 'Сортировка',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO yii_categories (`name_ru`) VALUES ('Авто');
INSERT INTO yii_categories (`name_ru`) VALUES ('Бельё');
INSERT INTO yii_categories (`name_ru`) VALUES ('Для дома');
INSERT INTO yii_categories (`name_ru`) VALUES ('Игры');
INSERT INTO yii_categories (`name_ru`) VALUES ('Интернет');
INSERT INTO yii_categories (`name_ru`) VALUES ('Интим');
INSERT INTO yii_categories (`name_ru`) VALUES ('Красота');
INSERT INTO yii_categories (`name_ru`) VALUES ('Рыбалка');
INSERT INTO yii_categories (`name_ru`) VALUES ('Спорт');
INSERT INTO yii_categories (`name_ru`) VALUES ('Строительство и ремонт');
INSERT INTO yii_categories (`name_ru`) VALUES ('Сувениры');
INSERT INTO yii_categories (`name_ru`) VALUES ('Туризм и отдых');
INSERT INTO yii_categories (`name_ru`) VALUES ('Электроника');

DROP TABLE IF EXISTS `yii_mailtemplates`;
CREATE TABLE IF NOT EXISTS `yii_mailtemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL DEFAULT '',
  `subject_en` varchar(100) NOT NULL DEFAULT '',
  `data` text,
  `data_en` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `yii_mailtemplates` (`id`, `name`, `subject`, `data`) VALUES (1, 'registration', 'Регистрация на сайте Gifm.ru', '<p style="font-size:16px;"><strong>Уважаемый пользователь!</strong></p><p>Вы успешно выбрали себе имя <strong>{domain_name}</strong> и заполнили профиль на сайте {site_name}.</p><p>Чтобы выбранное имя стало Вашим, не забудьте пожалуйста его {url_pay}.</p><p style="color:#d46019;"><strong>Также, для Вас мы зарегистрировали новый аккаунт:</strong></p><p><strong>E-mail (логин)</strong>: {email}<br><strong>Пароль:</strong> {passwd}<br><strong>Ваше кодовое слово:</strong> {secret_word}</p><p style="color:#d46019;"><strong>Используя этот аккаунт на нашем сайте {site_name}, Вы сможете</strong>:<ul><li>Управлять вашим доменным именем в личном кабинете.</li><li>Подключить Яндекс-Почту. Ваша почта теперь может выглядеть так: <strong>ya@name.ru</strong>. Вместо &quot;<strong>ya</strong>&quot; Вы сможете указать любое слово, а также создать до 1000 таких почтовых ящиков на Яндексе.</li><li>Привязать Ваш личный профиль в любой социальной сети к Вашему имени.</li><li>Создать Вашу личную страничку и разместить ссылки на профили в социальных сетях.</li><li>Привязать к Вашему имени свой собственный сайт.</li><li>Зарегистрировать себе другие имена, используя заполненный профиль.</li></ul></p><p><strong>Внимание!</strong> Для защиты своего аккаунта от действий третьих лиц, не разглашайте вышеупомянутые данные. Кроме того, рекомендуем не удалять письмо для возможности в дальнейшем уточнить необходимую информацию.</p><p>Спасибо за доверие!</p>');

DROP TABLE IF EXISTS `yii_payoptions`;
CREATE TABLE IF NOT EXISTS `yii_payoptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system` varchar(10) NOT NULL,
  `purse` varchar(13) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `mode` int(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `system` (`system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `yii_payoptions` (`id`, `system`, `purse`, `secret`, `mode`) VALUES
(1, 'WMR', 'R336951345921', 'jkWerRw45LqwPnUvK', 9),
(2, 'WMZ', 'Z325039326601', 'jkWerRw45LqwPnUvK', 9);

DROP TABLE IF EXISTS `yii_country`;
CREATE TABLE `yii_country` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `yii_country` VALUES ('1', 'Россия');
INSERT INTO `yii_country` VALUES ('2', 'Украина');
INSERT INTO `yii_country` VALUES ('3', 'Абхазия');
INSERT INTO `yii_country` VALUES ('4', 'Австралия');
INSERT INTO `yii_country` VALUES ('5', 'Австрия');
INSERT INTO `yii_country` VALUES ('6', 'Азербайджан');
INSERT INTO `yii_country` VALUES ('7', 'Албания');
INSERT INTO `yii_country` VALUES ('8', 'Алжир');
INSERT INTO `yii_country` VALUES ('9', 'Ангола');
INSERT INTO `yii_country` VALUES ('10', 'Ангуилья');
INSERT INTO `yii_country` VALUES ('11', 'Андорра');
INSERT INTO `yii_country` VALUES ('12', 'Антигуа и Барбуда');
INSERT INTO `yii_country` VALUES ('13', 'Антильские о-ва');
INSERT INTO `yii_country` VALUES ('14', 'Аргентина');
INSERT INTO `yii_country` VALUES ('15', 'Армения');
INSERT INTO `yii_country` VALUES ('16', 'Арулько');
INSERT INTO `yii_country` VALUES ('17', 'Афганистан');
INSERT INTO `yii_country` VALUES ('18', 'Багамские о-ва');
INSERT INTO `yii_country` VALUES ('19', 'Бангладеш');
INSERT INTO `yii_country` VALUES ('20', 'Барбадос');
INSERT INTO `yii_country` VALUES ('21', 'Бахрейн');
INSERT INTO `yii_country` VALUES ('22', 'Беларусь');
INSERT INTO `yii_country` VALUES ('23', 'Белиз');
INSERT INTO `yii_country` VALUES ('24', 'Бельгия');
INSERT INTO `yii_country` VALUES ('25', 'Бенин');
INSERT INTO `yii_country` VALUES ('26', 'Бермуды');
INSERT INTO `yii_country` VALUES ('27', 'Болгария');
INSERT INTO `yii_country` VALUES ('28', 'Боливия');
INSERT INTO `yii_country` VALUES ('29', 'Босния/Герцеговина');
INSERT INTO `yii_country` VALUES ('30', 'Ботсвана');
INSERT INTO `yii_country` VALUES ('31', 'Бразилия');
INSERT INTO `yii_country` VALUES ('32', 'Британские Виргинские о-ва');
INSERT INTO `yii_country` VALUES ('33', 'Бруней');
INSERT INTO `yii_country` VALUES ('34', 'Буркина Фасо');
INSERT INTO `yii_country` VALUES ('35', 'Бурунди');
INSERT INTO `yii_country` VALUES ('36', 'Бутан');
INSERT INTO `yii_country` VALUES ('37', 'Валлис и Футуна о-ва');
INSERT INTO `yii_country` VALUES ('38', 'Вануату');
INSERT INTO `yii_country` VALUES ('39', 'Великобритания');
INSERT INTO `yii_country` VALUES ('40', 'Венгрия');
INSERT INTO `yii_country` VALUES ('41', 'Венесуэла');
INSERT INTO `yii_country` VALUES ('42', 'Восточный Тимор');
INSERT INTO `yii_country` VALUES ('43', 'Вьетнам');
INSERT INTO `yii_country` VALUES ('44', 'Габон');
INSERT INTO `yii_country` VALUES ('45', 'Гаити');
INSERT INTO `yii_country` VALUES ('46', 'Гайана');
INSERT INTO `yii_country` VALUES ('47', 'Гамбия');
INSERT INTO `yii_country` VALUES ('48', 'Гана');
INSERT INTO `yii_country` VALUES ('49', 'Гваделупа');
INSERT INTO `yii_country` VALUES ('50', 'Гватемала');
INSERT INTO `yii_country` VALUES ('51', 'Гвинея');
INSERT INTO `yii_country` VALUES ('52', 'Гвинея-Бисау');
INSERT INTO `yii_country` VALUES ('53', 'Германия');
INSERT INTO `yii_country` VALUES ('54', 'Гернси о-в');
INSERT INTO `yii_country` VALUES ('55', 'Гибралтар');
INSERT INTO `yii_country` VALUES ('56', 'Гондурас');
INSERT INTO `yii_country` VALUES ('57', 'Гонконг');
INSERT INTO `yii_country` VALUES ('58', 'Гренада');
INSERT INTO `yii_country` VALUES ('59', 'Гренландия');
INSERT INTO `yii_country` VALUES ('60', 'Греция');
INSERT INTO `yii_country` VALUES ('61', 'Грузия');
INSERT INTO `yii_country` VALUES ('62', 'Дания');
INSERT INTO `yii_country` VALUES ('63', 'Джерси о-в');
INSERT INTO `yii_country` VALUES ('64', 'Джибути');
INSERT INTO `yii_country` VALUES ('65', 'Доминиканская республика');
INSERT INTO `yii_country` VALUES ('66', 'Египет');
INSERT INTO `yii_country` VALUES ('67', 'Замбия');
INSERT INTO `yii_country` VALUES ('68', 'Западная Сахара');
INSERT INTO `yii_country` VALUES ('69', 'Зимбабве');
INSERT INTO `yii_country` VALUES ('70', 'Израиль');
INSERT INTO `yii_country` VALUES ('71', 'Индия');
INSERT INTO `yii_country` VALUES ('72', 'Индонезия');
INSERT INTO `yii_country` VALUES ('73', 'Иордания');
INSERT INTO `yii_country` VALUES ('74', 'Ирак');
INSERT INTO `yii_country` VALUES ('75', 'Иран');
INSERT INTO `yii_country` VALUES ('76', 'Ирландия');
INSERT INTO `yii_country` VALUES ('77', 'Исландия');
INSERT INTO `yii_country` VALUES ('78', 'Испания');
INSERT INTO `yii_country` VALUES ('79', 'Италия');
INSERT INTO `yii_country` VALUES ('80', 'Йемен');
INSERT INTO `yii_country` VALUES ('81', 'Кабо-Верде');
INSERT INTO `yii_country` VALUES ('82', 'Казахстан');
INSERT INTO `yii_country` VALUES ('83', 'Камбоджа');
INSERT INTO `yii_country` VALUES ('84', 'Камерун');
INSERT INTO `yii_country` VALUES ('85', 'Канада');
INSERT INTO `yii_country` VALUES ('86', 'Катар');
INSERT INTO `yii_country` VALUES ('87', 'Кения');
INSERT INTO `yii_country` VALUES ('88', 'Кипр');
INSERT INTO `yii_country` VALUES ('89', 'Кирибати');
INSERT INTO `yii_country` VALUES ('90', 'Китай');
INSERT INTO `yii_country` VALUES ('91', 'Колумбия');
INSERT INTO `yii_country` VALUES ('92', 'Коморские о-ва');
INSERT INTO `yii_country` VALUES ('93', 'Конго (Brazzaville)');
INSERT INTO `yii_country` VALUES ('94', 'Конго (Kinshasa)');
INSERT INTO `yii_country` VALUES ('95', 'Коста-Рика');
INSERT INTO `yii_country` VALUES ('96', 'Кот-д\'Ивуар');
INSERT INTO `yii_country` VALUES ('97', 'Куба');
INSERT INTO `yii_country` VALUES ('98', 'Кувейт');
INSERT INTO `yii_country` VALUES ('99', 'Кука о-ва');
INSERT INTO `yii_country` VALUES ('100', 'Кыргызстан');
INSERT INTO `yii_country` VALUES ('101', 'Лаос');
INSERT INTO `yii_country` VALUES ('102', 'Латвия');
INSERT INTO `yii_country` VALUES ('103', 'Лесото');
INSERT INTO `yii_country` VALUES ('104', 'Либерия');
INSERT INTO `yii_country` VALUES ('105', 'Ливан');
INSERT INTO `yii_country` VALUES ('106', 'Ливия');
INSERT INTO `yii_country` VALUES ('107', 'Литва');
INSERT INTO `yii_country` VALUES ('108', 'Лихтенштейн');
INSERT INTO `yii_country` VALUES ('109', 'Люксембург');
INSERT INTO `yii_country` VALUES ('110', 'Маврикий');
INSERT INTO `yii_country` VALUES ('111', 'Мавритания');
INSERT INTO `yii_country` VALUES ('112', 'Мадагаскар');
INSERT INTO `yii_country` VALUES ('113', 'Македония');
INSERT INTO `yii_country` VALUES ('114', 'Малави');
INSERT INTO `yii_country` VALUES ('115', 'Малайзия');
INSERT INTO `yii_country` VALUES ('116', 'Мали');
INSERT INTO `yii_country` VALUES ('117', 'Мальдивские о-ва');
INSERT INTO `yii_country` VALUES ('118', 'Мальта');
INSERT INTO `yii_country` VALUES ('119', 'Мартиника о-в');
INSERT INTO `yii_country` VALUES ('120', 'Мексика');
INSERT INTO `yii_country` VALUES ('121', 'Мозамбик');
INSERT INTO `yii_country` VALUES ('122', 'Молдова');
INSERT INTO `yii_country` VALUES ('123', 'Монако');
INSERT INTO `yii_country` VALUES ('124', 'Монголия');
INSERT INTO `yii_country` VALUES ('125', 'Марокко');
INSERT INTO `yii_country` VALUES ('126', 'Мьянма (Бирма)');
INSERT INTO `yii_country` VALUES ('127', 'Мэн о-в');
INSERT INTO `yii_country` VALUES ('128', 'Намибия');
INSERT INTO `yii_country` VALUES ('129', 'Науру');
INSERT INTO `yii_country` VALUES ('130', 'Непал');
INSERT INTO `yii_country` VALUES ('131', 'Нигер');
INSERT INTO `yii_country` VALUES ('132', 'Нигерия');
INSERT INTO `yii_country` VALUES ('133', 'Нидерланды (Голландия)');
INSERT INTO `yii_country` VALUES ('134', 'Никарагуа');
INSERT INTO `yii_country` VALUES ('135', 'Новая Зеландия');
INSERT INTO `yii_country` VALUES ('136', 'Новая Каледония о-в');
INSERT INTO `yii_country` VALUES ('137', 'Норвегия');
INSERT INTO `yii_country` VALUES ('138', 'Норфолк о-в');
INSERT INTO `yii_country` VALUES ('139', 'О.А.Э.');
INSERT INTO `yii_country` VALUES ('140', 'Оман');
INSERT INTO `yii_country` VALUES ('141', 'Пакистан');
INSERT INTO `yii_country` VALUES ('142', 'Панама');
INSERT INTO `yii_country` VALUES ('143', 'Папуа Новая Гвинея');
INSERT INTO `yii_country` VALUES ('144', 'Парагвай');
INSERT INTO `yii_country` VALUES ('145', 'Перу');
INSERT INTO `yii_country` VALUES ('146', 'Питкэрн о-в');
INSERT INTO `yii_country` VALUES ('147', 'Польша');
INSERT INTO `yii_country` VALUES ('148', 'Португалия');
INSERT INTO `yii_country` VALUES ('149', 'Пуэрто Рико');
INSERT INTO `yii_country` VALUES ('150', 'Реюньон');
INSERT INTO `yii_country` VALUES ('151', 'Руанда');
INSERT INTO `yii_country` VALUES ('152', 'Румыния');
INSERT INTO `yii_country` VALUES ('153', 'США');
INSERT INTO `yii_country` VALUES ('154', 'Сальвадор');
INSERT INTO `yii_country` VALUES ('155', 'Самоа');
INSERT INTO `yii_country` VALUES ('156', 'Сан-Марино');
INSERT INTO `yii_country` VALUES ('157', 'Сан-Томе и Принсипи');
INSERT INTO `yii_country` VALUES ('158', 'Саудовская Аравия');
INSERT INTO `yii_country` VALUES ('159', 'Свазиленд');
INSERT INTO `yii_country` VALUES ('160', 'Святая Люсия');
INSERT INTO `yii_country` VALUES ('161', 'Святой Елены о-в');
INSERT INTO `yii_country` VALUES ('162', 'Северная Корея');
INSERT INTO `yii_country` VALUES ('163', 'Сейшеллы');
INSERT INTO `yii_country` VALUES ('164', 'Сен-Пьер и Микелон');
INSERT INTO `yii_country` VALUES ('165', 'Сенегал');
INSERT INTO `yii_country` VALUES ('166', 'Сент Китс и Невис');
INSERT INTO `yii_country` VALUES ('167', 'Сент-Винсент и Гренадины');
INSERT INTO `yii_country` VALUES ('168', 'Сербия');
INSERT INTO `yii_country` VALUES ('169', 'Сингапур');
INSERT INTO `yii_country` VALUES ('170', 'Сирия');
INSERT INTO `yii_country` VALUES ('171', 'Словакия');
INSERT INTO `yii_country` VALUES ('172', 'Словения');
INSERT INTO `yii_country` VALUES ('173', 'Соломоновы о-ва');
INSERT INTO `yii_country` VALUES ('174', 'Сомали');
INSERT INTO `yii_country` VALUES ('175', 'Судан');
INSERT INTO `yii_country` VALUES ('176', 'Суринам');
INSERT INTO `yii_country` VALUES ('177', 'Сьерра-Леоне');
INSERT INTO `yii_country` VALUES ('178', 'Таджикистан');
INSERT INTO `yii_country` VALUES ('179', 'Тайвань');
INSERT INTO `yii_country` VALUES ('180', 'Таиланд');
INSERT INTO `yii_country` VALUES ('181', 'Танзания');
INSERT INTO `yii_country` VALUES ('182', 'Того');
INSERT INTO `yii_country` VALUES ('183', 'Токелау о-ва');
INSERT INTO `yii_country` VALUES ('184', 'Тонга');
INSERT INTO `yii_country` VALUES ('185', 'Тринидад и Тобаго');
INSERT INTO `yii_country` VALUES ('186', 'Тувалу');
INSERT INTO `yii_country` VALUES ('187', 'Тунис');
INSERT INTO `yii_country` VALUES ('188', 'Туркменистан');
INSERT INTO `yii_country` VALUES ('189', 'Туркс и Кейкос');
INSERT INTO `yii_country` VALUES ('190', 'Турция');
INSERT INTO `yii_country` VALUES ('191', 'Уганда');
INSERT INTO `yii_country` VALUES ('192', 'Узбекистан');
INSERT INTO `yii_country` VALUES ('193', 'Уругвай');
INSERT INTO `yii_country` VALUES ('194', 'Фарерские о-ва');
INSERT INTO `yii_country` VALUES ('195', 'Фиджи');
INSERT INTO `yii_country` VALUES ('196', 'Филиппины');
INSERT INTO `yii_country` VALUES ('197', 'Финляндия');
INSERT INTO `yii_country` VALUES ('198', 'Франция');
INSERT INTO `yii_country` VALUES ('199', 'Французская Гвинея');
INSERT INTO `yii_country` VALUES ('200', 'Французская Полинезия');
INSERT INTO `yii_country` VALUES ('201', 'Хорватия');
INSERT INTO `yii_country` VALUES ('202', 'Чад');
INSERT INTO `yii_country` VALUES ('203', 'Черногория');
INSERT INTO `yii_country` VALUES ('204', 'Чехия');
INSERT INTO `yii_country` VALUES ('205', 'Чили');
INSERT INTO `yii_country` VALUES ('206', 'Швейцария');
INSERT INTO `yii_country` VALUES ('207', 'Швеция');
INSERT INTO `yii_country` VALUES ('208', 'Шри-Ланка');
INSERT INTO `yii_country` VALUES ('209', 'Эквадор');
INSERT INTO `yii_country` VALUES ('210', 'Экваториальная Гвинея');
INSERT INTO `yii_country` VALUES ('211', 'Эритрея');
INSERT INTO `yii_country` VALUES ('212', 'Эстония');
INSERT INTO `yii_country` VALUES ('213', 'Эфиопия');
INSERT INTO `yii_country` VALUES ('214', 'ЮАР');
INSERT INTO `yii_country` VALUES ('215', 'Южная Корея');
INSERT INTO `yii_country` VALUES ('216', 'Южная Осетия');
INSERT INTO `yii_country` VALUES ('217', 'Ямайка');
INSERT INTO `yii_country` VALUES ('218', 'Япония');



