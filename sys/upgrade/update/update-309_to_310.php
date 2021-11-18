<?php 

db::query("DROP TABLE `user_group`"); 
db::query("DROP TABLE `all_accesses`"); 

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