<?php 

db::query("CREATE TABLE IF NOT EXISTS `notification` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `object` varchar(128) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `type` varchar(128) NOT NULL,
  `group_id` varchar(128) NOT NULL DEFAULT 'other',
  `data` text NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"); 

db::query("ALTER TABLE `notification` ADD PRIMARY KEY (`id`);"); 
db::query("ALTER TABLE `notification` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;"); 