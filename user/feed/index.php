<?php 

if (!defined('ROOTPATH')) {
	die('Доступ запрещен'); 
}

only_reg();

$set['title'] = __('Новости друзей'); 
get_header(); 

$args = array(
	'user_id' => get_user_id(), 
); 

$query = new DB_Feeds($args); 

if ($query->items) {
	foreach($query->items AS $feed) {
		ds_output_feed($feed); 
	}	

	if ( $query->pages > 1 ) {
	    str('?', $query->pages, $query->paged);
	}
} else {
    echo '<div class="empty empty-feed">';
    echo '<h2>' . __('Лента событий пуста') . '</h2>';
    echo '<p>' . __('Похоже, в вашей ленте пока нет новых событий. Здесь будут отображаться все публикации людей, на которых вы подписаны.') . '</p>';
    echo '</div>';
}
	
get_footer(); 