<?php 

db::query("ALTER TABLE `ban` CHANGE `navsegda` `forever` INT(1) NULL DEFAULT NULL"); 
db::query("ALTER TABLE `ban` CHANGE `prich` `comment` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL"); 
db::query("ALTER TABLE `ban` CHANGE `time` `time_until` INT(11) NULL DEFAULT NULL"); 
db::query("ALTER TABLE `ban` CHANGE `id_user` `user_id` BIGINT(20) NOT NULL"); 
db::query("ALTER TABLE `ban` CHANGE `pochemu` `reason` VARCHAR(28) NULL DEFAULT 'spam'"); 
db::query("ALTER TABLE `ban` CHANGE `razdel` `time_create` INT(11) NOT NULL"); 
db::query("ALTER TABLE `ban` CHANGE `id_ban` `banned_id` BIGINT(20) NOT NULL"); 
db::query("ALTER TABLE `ban` CHANGE `post` `hide` INT(1) NULL DEFAULT '0'"); 


@unlink(ROOTPATH.'/pages/new_mess.php'); 