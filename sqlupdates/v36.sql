UPDATE `settings` SET `value` = '3.6' WHERE `settings`.`type` = 'current_version';
ALTER TABLE `currencies` CHANGE `exchange_rate` `exchange_rate` DOUBLE(10,5) NULL;
ALTER TABLE `currencies` CHANGE `status` `status` INT(10) NOT NULL DEFAULT '1';
COMMIT;
