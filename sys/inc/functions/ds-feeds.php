<?php 

/**
* Подписывает пользователя на новости
*/
function add_subscription($type, $user_id, $object_id) 
{
	$subscribe = db::fetch("SELECT * FROM subscriptions WHERE user_id = '" . $user_id . "' AND type = '" . $type . "' AND object_id = '" . $object_id . "' LIMIT 1"); 

	if (empty($subscribe)) {
		do_event('ds_create_subscription', $user_id, $object_id); 
		do_event('ds_create_subscription_' . $type, $user_id, $object_id); 

		db::insert('subscriptions', array(
			'type' => $type, 
			'user_id' => $user_id, 
			'object_id' => $object_id, 
		)); 
	}
}

/**
* Удалить подписку 
*/ 
function delete_subscription($type, $user_id, $object_id) 
{
	$subscribe = db::fetch("SELECT * FROM subscriptions WHERE user_id = '" . $user_id . "' AND type = '" . $type . "' AND object_id = '" . $object_id . "' LIMIT 1"); 

	if (!empty($subscribe)) {
		do_event('ds_delete_subscription', $user_id, $object_id); 
		do_event('ds_delete_subscription_' . $type, $user_id, $object_id); 
		
		db::delete('subscriptions', array(
			'type' => $type, 
			'user_id' => $user_id,  
			'object_id' => $object_id, 
		)); 
	}
}

/**
* Регистрирует новый тип в ленте новостей
*/ 
function register_feed($uid, $args = array()) 
{
	$setup = ds_get('ds_feed_setup', array()); 
	$links = use_filters('ds_feeds_action_links', array(
		// to do..
	));

	$default = array(
		'callback_output' => false, 
		'callback_create' => false, 
		'event_name' 	  => false, 
		'labels' => array(
			'feed_name' => __('Лента ID %s', $uid), 
		), 
	); 

	if (!empty($links)) {
		$default['action'] = array(
			'url' => false, 
			'icon' => 'fa-ellipsis-h', 
			'title' => __('Действие'), 
			'items' => $links,  
		); 
	}

	$setup['feeds'][$uid] = array_replace($default, $args); 


	ds_set('ds_feed_setup', $setup); 
	do_event('ds_register_feed', $setup['feeds'][$uid]); 
}

function handle_feeds_init() 
{
	$hook_enable_feed = use_filters('ds_supported_feeds', true); 

	/**
	* Хук позволяет отключать ленты пользователей
	*/ 
	if ($hook_enable_feed === false) {
		return ; 
	}

	/**
	* Фотографии пользователя
	*/ 
	register_feed('ds_photos', array(
		'callback_output' => 'ds_feed_template_photos', 
		'callback_create' => 'add_feed_photos', 
		'event_name' => 'ds_files_photos_uploaded', 
		'labels' => array(
			'feed_name' => __('Фотографии'), 
			'feed_description' => __('Создает новость для подписчиков пользователя, о новых фотографиях.'), 
		),
	)); 

	/**
	* Музыка пользователя
	*/ 
	register_feed('ds_music', array(
		'callback_output' => 'ds_feed_template_music', 
		'callback_create' => 'add_feed_music', 
		'event_name' => 'ds_files_music_uploaded', 
		'labels' => array(
			'feed_name' => __('Музыка'), 
			'feed_description' => __('Создает новость для подписчиков пользователя, о новых аудиофайлах.'), 
		),
	)); 

	do_event('ds_feeds_default_registered'); 

	$setup = ds_get('ds_feed_setup', array());  
	foreach($setup['feeds'] AS $feed) {
		add_event($feed['event_name'], $feed['callback_create']); 
	}

	ds_set('ds_feed_setup', $setup); 
}

/**
* Добавляет в ленту пользователя новую запись
* Обязательные параметры $feed_id и $object_id 
*/ 
function add_feed($feed_id, $object_id, $user_id = false, $content = '')  
{
	if ($user_id === false) {
		$user_id = get_user_id(); 
	}

	// Если это массив, сериализуем его
	if (is_array($content)) {
		$content = serialize($content); 
	}

	db::insert('feeds', array(
		'user_id'   => $user_id, 
		'slug'      => $feed_id, 
		'object_id' => $object_id, 
		'content'   => $content, 
		'time_create'   => time(),
	)); 

	return db::insert_id(); 
}

function ds_output_feed($feed) 
{
	$setup = ds_get('ds_feed_setup', array());

	if (array_key_exists($feed['slug'], $setup['feeds'])) {
		$slug = $feed['slug']; 

		$hook = use_filters('ds_feed_pre_output', false, $slug); 
		if ($hook !== false) {
			return ;
		}

		if (is_callable($setup['feeds'][$slug]['callback_output'])) {
			call_user_func($setup['feeds'][$slug]['callback_output'], $feed);
		} elseif (is_file($setup['feeds'][$slug]['callback_output'])) {
			require $setup['feeds'][$slug]['callback_output']; 
		} else {
			echo '<div class="post"><div class="post-content">not callable: ' . $slug . '</div></div>'; 
		}
	}
}

/**
* Обновляет ленту пользователя
*/ 
function update_user_feed($uid, $content = '')  
{
	// Если это массив, сериализуем его
	if (is_array($content)) {
		$content = serialize($content); 
	}

	db::update('feeds', array(
		'content'   => $content,
	), array('id' => $uid)); 
}

/**
* Удаляет запись из ленты пользователя
*/ 
function delete_user_feed($uid)  
{
	db::delete('feeds', array('id' => $uid)); 
	db::delete('comments', array(
		'object' => 'feeds', 
		'object_id' => $uid, 
	)); 
}

function add_feed_photos($file, $term) 
{
	$feed = db::fetch("SELECT * FROM `feeds` WHERE `slug` = 'ds_photos' AND `object_id` = '" . $term['term_id'] . "' AND `time_create` >= '" . (time() - 3600) . "' ORDER BY id DESC LIMIT 1");

	if (isset($feed['id'])) {
		$photos = unserialize($feed['content']); 

		if (count($photos) >= 1 && count($photos) <= 9) {
			array_unshift($photos, $file['id']); 

		    add_object_attachments($file['id'], array(
	            'object' => 'feed', 
	            'object_id' => $feed_id, 
	        )); 

			update_user_feed($feed['id'], $photos); 
			return ;	
		}
	}

	$photos = array($file['id']); 
	$feed_id = add_feed('ds_photos', $term['term_id'], $file['user_id'], $photos); 

	if ($feed_id) {
	    add_object_attachments($file['id'], array(
            'object' => 'feed', 
            'object_id' => $feed_id, 
        )); 
	}
}

function add_feed_music($file, $term) 
{
	$feed = db::fetch("SELECT * FROM `feeds` WHERE `slug` = 'ds_music' AND `object_id` = '" . $term['term_id'] . "' AND `time_create` >= '" . (time() - 3600) . "' ORDER BY id DESC LIMIT 1"); 
	if (isset($feed['id'])) {
		$music = unserialize($feed['content']); 

		if (count($music) >= 1 && count($music) <= 9) {
			array_unshift($music, $file['id']); 

		    add_object_attachments($file['id'], array(
	            'object' => 'feed', 
	            'object_id' => $feed_id, 
	        )); 

			update_user_feed($feed['id'], $music); 
			return ;	
		}
	}

	$music = array($file['id']); 
	$feed_id = add_feed('ds_music', $term['term_id'], $file['user_id'], $music); 

	add_object_attachments($file['id'], array(
        'object' => 'feed', 
        'object_id' => $feed_id, 
    )); 
}

// music
function ds_feed_template_music($feed) 
{
	$files = unserialize($feed['content']); 
	$setup = ds_get('ds_feed_setup', array()); 

	if ($feed['user_id'] == get_user_id()) {
		unset($setup['feeds']['ds_music']['action']['items']['complaint']);
		
		$setup['feeds']['ds_music']['action']['items'][] = array(
			'title' => __('Удалить запись'), 
			'url' => '/delete/', 
		); 
	}

	$header = array(
		'image' => '<a href="' . get_user_url($feed['user_id']) . '">' . get_avatar($feed['user_id']) . '</a>', 
		'content' => array(
			'post_title' => '<a href="' . get_user_url($feed['user_id']) . '">' . get_user_nick($feed['user_id']) . '</a>', 
			'post_time' => $feed['time_create'], 
		), 
	); 

	if (!empty($setup['feeds']['ds_music']['action'])) {
		$header['action'] = $setup['feeds']['ds_music']['action']; 
	}

	$content = get_output_media($files); 

	$panels = array(
		get_panel_likes('feeds', $feed),
		get_panel_comment('feeds', array(
			'url' => '/feed/' . $feed['id'], 
			'object_id' => $feed['id'], 
		)), 
	); 

	echo get_template_post(array(
		'header' => $header, 
		'content' => $content, 
		'panel' => join('', $panels), 
	)); 
}

// photos
function ds_feed_template_photos($feed) 
{
	$files = unserialize($feed['content']); 
	$setup = ds_get('ds_feed_setup', array()); 

	if ($feed['user_id'] == get_user_id()) {
		unset($setup['feeds']['ds_photos']['action']['items']['complaint']);
		
		$setup['feeds']['ds_photos']['action']['items'][] = array(
			'title' => __('Удалить запись'), 
			'url' => '/delete/', 
		); 
	}

	$header = array(
		'image' => '<a href="' . get_user_url($feed['user_id']) . '">' . get_avatar($feed['user_id']) . '</a>', 
		'content' => array(
			'post_title' => '<a href="' . get_user_url($feed['user_id']) . '">' . get_user_nick($feed['user_id']) . '</a>', 
			'post_time' => $feed['time_create'], 
		), 
	); 

	if (!empty($setup['feeds']['ds_photos']['action'])) {
		$header['action'] = $setup['feeds']['ds_photos']['action']; 
	}

	$images = array(); 
	foreach($files AS $file_id) { 
		$file = get_file($file_id); 

		if ($file) {
			$thumbnail = get_file_thumbnail($file, 'medium'); 
			$images[] = '<a href="' . get_file_link($file) . '">' . ds_file_thumbnail($file['id'], 'medium') . '</a>'; 
		}
	}
	$content = get_grid_images($images); 

	$panels = array(
		get_panel_likes('feeds', $feed),
		get_panel_comment('feeds', array(
			'url' => '/feed/' . $feed['id'], 
			'object_id' => $feed['id'], 
		)), 
	); 

	echo get_template_post(array(
		'header' => $header, 
		'content' => $content, 
		'panel' => join('', $panels), 
	)); 
}