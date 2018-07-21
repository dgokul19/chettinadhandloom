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
