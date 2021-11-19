<?php 

/**
 * Удаление устаревших таблиц базы данных
 * */

db::query("DROP TABLE `user_group`"); 
db::query("DROP TABLE `all_accesses`");

/**
 * Обновляем новые группы доступа
 * */

db::query("TRUNCATE `user_group_access`"); 

$user_group_access = array(
	array('id_group' => '9','id_access' => 'adm_accesses'),
	array('id_group' => '15','id_access' => 'adm_accesses'),
	array('id_group' => '3','id_access' => 'adm_banlist'),
	array('id_group' => '11','id_access' => 'adm_banlist'),
	array('id_group' => '12','id_access' => 'adm_banlist'),
	array('id_group' => '6','id_access' => 'adm_banlist'),
	array('id_group' => '12','id_access' => 'adm_info'),
	array('id_group' => '4','id_access' => 'adm_info'),
	array('id_group' => '6','id_access' => 'adm_info'),
	array('id_group' => '11','id_access' => 'adm_info'),
	array('id_group' => '9','id_access' => 'adm_info'),
	array('id_group' => '8','id_access' => 'adm_info'),
	array('id_group' => '15','id_access' => 'adm_info'),
	array('id_group' => '5','id_access' => 'adm_info'),
	array('id_group' => '2','id_access' => 'adm_info'),
	array('id_group' => '3','id_access' => 'adm_panel_show'),
	array('id_group' => '6','id_access' => 'adm_panel_show'),
	array('id_group' => '11','id_access' => 'adm_panel_show'),
	array('id_group' => '4','id_access' => 'adm_panel_show'),
	array('id_group' => '9','id_access' => 'adm_panel_show'),
	array('id_group' => '8','id_access' => 'adm_panel_show'),
	array('id_group' => '15','id_access' => 'adm_panel_show'),
	array('id_group' => '12','id_access' => 'adm_panel_show'),
	array('id_group' => '7','id_access' => 'adm_panel_show'),
	array('id_group' => '2','id_access' => 'adm_panel_show'),
	array('id_group' => '5','id_access' => 'adm_panel_show'),
	array('id_group' => '2','id_access' => 'adm_ref'),
	array('id_group' => '5','id_access' => 'adm_ref'),
	array('id_group' => '8','id_access' => 'adm_set_sys'),
	array('id_group' => '15','id_access' => 'adm_set_sys'),
	array('id_group' => '9','id_access' => 'adm_set_sys'),
	array('id_group' => '2','id_access' => 'adm_show_adm'),
	array('id_group' => '12','id_access' => 'adm_show_adm'),
	array('id_group' => '4','id_access' => 'adm_show_adm'),
	array('id_group' => '11','id_access' => 'adm_show_adm'),
	array('id_group' => '6','id_access' => 'adm_show_adm'),
	array('id_group' => '3','id_access' => 'adm_show_adm'),
	array('id_group' => '3','id_access' => 'adm_statistic'),
	array('id_group' => '12','id_access' => 'adm_statistic'),
	array('id_group' => '2','id_access' => 'adm_statistic'),
	array('id_group' => '6','id_access' => 'adm_statistic'),
	array('id_group' => '4','id_access' => 'adm_statistic'),
	array('id_group' => '5','id_access' => 'adm_statistic'),
	array('id_group' => '11','id_access' => 'adm_statistic'),
	array('id_group' => '9','id_access' => 'adm_themes'),
	array('id_group' => '15','id_access' => 'adm_themes'),
	array('id_group' => '9','id_access' => 'adm_users_list'),
	array('id_group' => '7','id_access' => 'adm_users_list'),
	array('id_group' => '8','id_access' => 'adm_users_list'),
	array('id_group' => '15','id_access' => 'adm_users_list'),
	array('id_group' => '15','id_access' => 'forum_comment_delete'),
	array('id_group' => '15','id_access' => 'forum_comment_edit'),
	array('id_group' => '15','id_access' => 'forum_delete'),
	array('id_group' => '15','id_access' => 'forum_edit'),
	array('id_group' => '15','id_access' => 'forum_topic_delete'),
	array('id_group' => '15','id_access' => 'forum_topic_edit'),
	array('id_group' => '9','id_access' => 'plugins'),
	array('id_group' => '15','id_access' => 'plugins'),
	array('id_group' => '9','id_access' => 'update_core'),
	array('id_group' => '15','id_access' => 'update_core'),
	array('id_group' => '11','id_access' => 'user_ban_set'),
	array('id_group' => '9','id_access' => 'user_ban_set'),
	array('id_group' => '12','id_access' => 'user_ban_set'),
	array('id_group' => '7','id_access' => 'user_ban_set'),
	array('id_group' => '2','id_access' => 'user_ban_set'),
	array('id_group' => '8','id_access' => 'user_ban_set'),
	array('id_group' => '15','id_access' => 'user_ban_set'),
	array('id_group' => '5','id_access' => 'user_ban_set_h'),
	array('id_group' => '2','id_access' => 'user_ban_set_h'),
	array('id_group' => '11','id_access' => 'user_ban_set_h'),
	array('id_group' => '3','id_access' => 'user_ban_set_h'),
	array('id_group' => '12','id_access' => 'user_ban_set_h'),
	array('id_group' => '6','id_access' => 'user_ban_set_h'),
	array('id_group' => '8','id_access' => 'user_ban_unset'),
	array('id_group' => '15','id_access' => 'user_ban_unset'),
	array('id_group' => '7','id_access' => 'user_ban_unset'),
	array('id_group' => '2','id_access' => 'user_ban_unset'),
	array('id_group' => '9','id_access' => 'user_ban_unset'),
	array('id_group' => '8','id_access' => 'user_delete'),
	array('id_group' => '15','id_access' => 'user_delete'),
	array('id_group' => '9','id_access' => 'user_delete'),
	array('id_group' => '9','id_access' => 'user_edit'),
	array('id_group' => '8','id_access' => 'user_edit'),
	array('id_group' => '15','id_access' => 'user_edit'),
	array('id_group' => '9','id_access' => 'user_files_delete'),
	array('id_group' => '15','id_access' => 'user_files_delete'),
	array('id_group' => '8','id_access' => 'user_files_delete'),
	array('id_group' => '7','id_access' => 'user_files_delete'),
	array('id_group' => '7','id_access' => 'user_files_edit'),
	array('id_group' => '9','id_access' => 'user_files_edit'),
	array('id_group' => '15','id_access' => 'user_files_edit'),
	array('id_group' => '8','id_access' => 'user_files_edit'),
	array('id_group' => '9','id_access' => 'user_group'),
	array('id_group' => '15','id_access' => 'user_group'),
	array('id_group' => '2','id_access' => 'user_prof_edit'),
	array('id_group' => '3','id_access' => 'user_prof_edit'),
	array('id_group' => '5','id_access' => 'user_prof_edit'),
	array('id_group' => '3','id_access' => 'user_show_add_info'),
	array('id_group' => '2','id_access' => 'user_show_add_info'),
	array('id_group' => '3','id_access' => 'user_show_ip'),
	array('id_group' => '3','id_access' => 'user_show_ua'),
	array('id_group' => '2','id_access' => 'user_show_ua'),
	array('id_group' => '6','id_access' => 'user_show_ua')
);

foreach($user_group_access AS $data) {
	db::insert('user_group_access', $data); 
}

/**
 * Удаление устаревших файлов
 * */

$delete_files = array(
	'adm_panel/adm_log.php', 
	'adm_panel/administration.php', 
	'adm_panel/ban_ip.php', 
	'adm_panel/banlist.php', 
	'adm_panel/delete_user.php', 
	'adm_panel/delete_users.php', 
	'adm_panel/menu.php', 
	'adm_panel/mysql.php', 
	'adm_panel/opsos.php', 
	'adm_panel/profile.php', 
	'adm_panel/referals.php', 
	'adm_panel/settings_loads.php', 
	'adm_panel/settings_user.php', 
	'adm_panel/statistic.php', 
	'adm_panel/styles.php', 
	'adm_panel/tables.php', 
	'adm_panel/user.php', 
	'pages/ban_ip.php', 
	'pages/online_g.php', 
	'sys/inc/MultiWave.php', 
	'sys/inc/adm_check.php', 
	'sys/inc/censure.php', 
	'sys/inc/downloadfile.php', 
	'sys/inc/fnc.php', 
	'sys/inc/gif_resize.php', 
	'sys/inc/gifdecoder.php', 
	'sys/inc/gifencoder.php', 
	'sys/inc/mp3.php', 
	'sys/inc/scrmaker.php', 
	'sys/inc/strip_tags_smart.php', 
	'sys/inc/tar.php', 
	'sys/inc/utf8_convert_case.php', 
	'sys/inc/utf8_html_entity_decode.php', 
	'sys/inc/zip.php', 
	'sys/upgrade/db_install/all_accesses.sql', 
	'sys/upgrade/db_install/user_group.sql', 
); 

foreach($delete_files AS $file) {
	if (is_file(ROOTPATH . '/' . $file)) {
		unlink(ROOTPATH . '/' . $file); 
	}
}