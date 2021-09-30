
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(10) unsigned AUTO_INCREMENT,
  `name` varchar(32),
  `level` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16;

INSERT INTO `user_group` (`id`, `name`, `level`) VALUES
(1, 'Пользователь', 0),
(7, 'Модератор', 2),
(8, 'Администратор', 3),
(9, 'Главный администратор', 9),
(15, 'Создатель', 10);