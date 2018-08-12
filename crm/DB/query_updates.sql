-- ALTER TABLE chettinad_handloom.ch_product_category ADD IF NOT EXISTS c_ref_code varchar(20) NOT NULL AFTER id;
-- UPDATE `ch_product_category` SET `c_ref_code`='pdc01' WHERE `id`='1';
-- UPDATE `ch_product_category` SET `c_ref_code`='pdc02' WHERE `id`='2';
-- UPDATE `ch_product_category` SET `c_ref_code`='pdc03' WHERE `id`='3';

-- ALTER TABLE chettinad_handloom.ch_product_category ADD IF NOT EXISTS c_ref_code varchar(20) NOT NULL AFTER id;
-- UPDATE `ch_product_category` SET `c_ref_code`='pdc01' WHERE `id`='1';
-- UPDATE `ch_product_category` SET `c_ref_code`='pdc02' WHERE `id`='2';
-- UPDATE `ch_product_category` SET `c_ref_code`='pdc03' WHERE `id`='3';

-- ALTER TABLE `ch_product_details` ADD COLUMN `published` tinyint(1) NOT NULL DEFAULT 0 AFTER `status`;
-- UPDATE `ch_product_details` SET `published`=1;

-- RENAME TABLE `chettinad_handloom`.`ch_product_model` TO `chettinad_handloom`.`ch_product_albums`;
-- ALTER TABLE `ch_product_albums` CHANGE `model_code` `album_code` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `model_name` `album_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- ALTER TABLE `ch_product_details` CHANGE `model_id` `album_id` INT(255) NOT NULL;

-- ALTER TABLE `ch_product_albums` ADD `category_id` INT(200) NOT NULL AFTER `album_name`;
-- UPDATE `ch_product_albums` SET `category_id` = '1' WHERE `ch_product_albums`.`id` = 1;
-- UPDATE `ch_product_albums` SET `category_id` = '1' WHERE `ch_product_albums`.`id` = 2;
-- UPDATE `ch_product_albums` SET `category_id` = '2' WHERE `ch_product_albums`.`id` = 3;
-- INSERT INTO `ch_product_albums` (`id`, `album_code`, `album_name`, `category_id`, `description`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'album-2-2', 'album 2-2', '2', 'Regular plain saree pattern', '1', '2017-09-26 02:28:48', '2018-07-23 01:48:24'), (NULL, 'album-3-1', 'album 3-1', '3', 'Temple buttas desgins', '1', '2017-09-26 02:28:48', '2018-07-23 01:49:00'), (NULL, 'album-3-2', 'album 3-2', '3', 'Annapatchai crafts', '1', '2017-09-26 02:28:49', '2018-07-23 01:49:00');

-- UPDATE `ch_product_albums` SET `album_code` = 'album-1-1' WHERE `ch_product_albums`.`id` = 1;
-- UPDATE `ch_product_albums` SET `album_code` = 'album-1-2' WHERE `ch_product_albums`.`id` = 2;
-- UPDATE `ch_product_albums` SET `album_code` = 'album-2-1' WHERE `ch_product_albums`.`id` = 3;

-- UPDATE `ch_product_albums` SET `album_name` = 'album 1-1' WHERE `ch_product_albums`.`id` = 1;
-- UPDATE `ch_product_albums` SET `album_name` = 'album 1-2' WHERE `ch_product_albums`.`id` = 2;
-- UPDATE `ch_product_albums` SET `album_name` = 'album 1-3' WHERE `ch_product_albums`.`id` = 3;

-- UPDATE `ch_product_details` SET `album_id` = '3' WHERE `ch_product_details`.`id` = 6;
-- UPDATE `ch_product_details` SET `album_id` = '4' WHERE `ch_product_details`.`id` = 5;
-- UPDATE `ch_product_details` SET `album_id` = '4' WHERE `ch_product_details`.`id` = 7;
-- UPDATE `ch_product_details` SET `album_id` = '3' WHERE `ch_product_details`.`id` = 8;

-- UPDATE `ch_product_details` SET `album_id` = '5' WHERE `ch_product_details`.`id` = 9;
-- UPDATE `ch_product_details` SET `album_id` = '5' WHERE `ch_product_details`.`id` = 10;
-- UPDATE `ch_product_details` SET `album_id` = '5' WHERE `ch_product_details`.`id` = 12;
-- UPDATE `ch_product_details` SET `album_id` = '6' WHERE `ch_product_details`.`id` = 11;
-- UPDATE `ch_product_details` SET `album_id` = '6' WHERE `ch_product_details`.`id` = 14;
-- UPDATE `ch_product_details` SET `album_id` = '6' WHERE `ch_product_details`.`id` = 13;

-- CREATE TABLE IF NOT EXISTS `chettinad_handloom`.`ch_filter_price_range` (
--     id int(200) NOT NULL PRIMARY KEY AUTO_INCREMENT,
--     option_name varchar(50) NOT NULL,
--     range_type ENUM ('BETWEEN','ABOVE') NOT NULL,
--     value_from float(32,2) NOT NULL,
--     value_to float(32,2) NULL,
--     is_active tinyint(1) DEFAULT 1,
--     created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
-- );
-- 
-- INSERT INTO `ch_filter_price_range`(`option_name`, `range_type`, `value_from`, `value_to`) VALUES ('Below INR 1000', 'BETWEEN', '0', '1000');
-- INSERT INTO `ch_filter_price_range`(`option_name`, `range_type`, `value_from`, `value_to`) VALUES ('INR 1000 - INR 2000', 'BETWEEN', '1000', '2000');
-- INSERT INTO `ch_filter_price_range`(`option_name`, `range_type`, `value_from`) VALUES ('Above INR 2000', 'ABOVE', '2000');
-- 
-- UPDATE `ch_product_albums` SET `album_name` = 'album 2-1' WHERE `ch_product_albums`.`id` = 3;

-- INSERT INTO `ch_product_albums` (`id`, `album_code`, `album_name`, `category_id`, `description`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'album-1-2', 'PRAGATHAM', '2', 'PRAGATHAM description', '1', '2017-09-26 02:28:48', '2018-07-23 01:53:52');
-- INSERT INTO `ch_product_albums` (`id`, `album_code`, `album_name`, `category_id`, `description`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'album-1-2', 'BUTTIDADAR', '2', 'BUTTIDADAR description', '1', '2017-09-26 02:28:48', '2018-07-23 01:53:52')
-- ALTER TABLE `ch_product_albums` ADD `cover_picture` VARCHAR(255) NULL AFTER `description`;
-- UPDATE `ch_product_albums` SET `cover_picture` = '36460026_1030370157110602_2100740578319794176_n.jpg' WHERE `ch_product_albums`.`id` = 5;
-- UPDATE `ch_product_albums` SET `cover_picture` = '36731837_1038579179623033_4619573597017473024_n.jpg' WHERE `ch_product_albums`.`id` = 1;
-- UPDATE `ch_product_albums` SET `cover_picture` = '36781641_1038579152956369_116539341961953280_n.jpg' WHERE `ch_product_albums`.`id` = 2;
-- UPDATE `ch_product_albums` SET `cover_picture` = '36969090_1043567359124215_5275818160027598848_n.jpg' WHERE `ch_product_albums`.`id` = 3;
-- UPDATE `ch_product_albums` SET `cover_picture` = '37014470_1043567219124229_5027679216229941248_n.jpg' WHERE `ch_product_albums`.`id` = 4;
-- UPDATE `ch_product_albums` SET `cover_picture` = '37249056_1047521222062162_7313610439231799296_n.jpg' WHERE `ch_product_albums`.`id` = 6;
-- UPDATE `ch_product_albums` SET `cover_picture` = '37386741_1048509735296644_6379802197378465792_n.jpg' WHERE `ch_product_albums`.`id` = 7;
-- UPDATE `ch_product_albums` SET `cover_picture` = '38046165_1067608520053432_5507235623615856640_n.jpg' WHERE `ch_product_albums`.`id` = 8;
-- UPDATE `ch_product_albums` SET `album_code` = 'pragatham' WHERE `ch_product_albums`.`id` = 7;
-- UPDATE `ch_product_albums` SET `album_code` = 'buttidadar' WHERE `ch_product_albums`.`id` = 8;
-- UPDATE `ch_product_albums` SET `description` = 'Mangalavastram caption' WHERE `ch_product_albums`.`id` = 4;
-- UPDATE `ch_product_albums` SET `album_name` = 'MANGALAVASTRAM' WHERE `ch_product_albums`.`id` = 4;
-- UPDATE `ch_product_albums` SET `album_code` = 'mangalavastram' WHERE `ch_product_albums`.`id` = 4;

-- ALTER TABLE `ch_app_users` CHANGE `username` `full_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
-- ALTER TABLE `ch_app_users` DROP `gender`, DROP `DOB`, DROP `picture_url`, DROP `profile_url`, DROP `cover_picture_url`, DROP `userType`, DROP `userProfile_status`, DROP `OTP`, DROP `otp_is_verified`;
-- ALTER TABLE `ch_app_users` DROP `locale`;
-- ALTER TABLE `ch_app_users` CHANGE `modified` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00';
-- ALTER TABLE `ch_app_users` ADD `email_otp` INT(10) NULL DEFAULT NULL AFTER `last_login`, ADD `is_email_verified` TINYINT(1) NOT NULL DEFAULT '0' AFTER `email_otp`;
-- ALTER TABLE `ch_app_users` CHANGE `email` `email_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
-- ALTER TABLE `ch_app_users` ADD `country_code` VARCHAR(10) NOT NULL AFTER `email_id`;
-- ALTER TABLE `ch_app_users` ADD UNIQUE(`email_id`);







