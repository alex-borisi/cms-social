CREATE TABLE IF NOT EXISTS `files_attachments` (
  `id` bigint(20) NOT NULL,
  `file_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `object` varchar(128) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `time` int(11) NOT NULL,
  `param1` varchar(128) NOT NULL,
  `param1_id` bigint(20) NOT NULL DEFAULT '-1',
  `param2` varchar(128) NOT NULL,
  `param2_id` bigint(20) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `files_attachments` ADD PRIMARY KEY (`id`);
ALTER TABLE `files_attachments` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;SET FOREIGN_KEY_CHECKS=1;