<?php 

db::query("CREATE TABLE IF NOT EXISTS `files_attachments` (
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"); 

db::query("ALTER TABLE `files_attachments` ADD PRIMARY KEY (`id`)"); 
db::query("ALTER TABLE `files_attachments` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1"); 


$q = db::query("SELECT * FROM `mail`"); 
while($post = $q->fetch_assoc()) {
    $array = get_text_array($post['msg']); 

    $attachments = array(); 
    foreach($array['data']['attachments'] AS $attach_id) {
        $attach = db::fetch("SELECT * FROM `files_attachments` WHERE `object` = 'mail' AND `object_id` = '" . $post['id'] . "'");
        $file = get_file($attach_id); 

        if (!$attach && $file) {
            $attachments[] = $attach_id; 
        }
    }

    if (!empty($attachments)) {
        add_object_attachments($attachments, array(
            'object' => 'mail', 
            'object_id' => $post['id'], 
            'param1_id' => $post['user_id'], 
            'param2_id' => $post['contact_id'], 
        )); 
    }

    $array['data']['attachments'] = $attachments; 

    $content = '<!-- CMS-Social Data {{' . serialize(use_filters('ds_mail_serialize_data', $array['data'])) . '}} -->' . "\r"; 
    $content .= $array['content']; 

    db::query("UPDATE mail SET `msg` = '" . $content . "' WHERE id = '" . $post['id'] . "' LIMIT 1"); 
} 



$q = db::query("SELECT * FROM `comments`"); 
while($post = $q->fetch_assoc()) {
    $array = get_text_array($post['msg']); 

    $attachments = array(); 
    foreach($array['data']['attachments'] AS $attach_id) {
        $attach = db::fetch("SELECT * FROM `files_attachments` WHERE `object` = 'comment' AND `object_id` = '" . $post['id'] . "'");
        $file = get_file($attach_id); 

        if (!$attach && $file) {
            $attachments[] = $attach_id; 
        }
    }

    if (!empty($attachments)) {
        add_object_attachments($attachments, array(
            'object' => 'comment', 
            'object_id' => $post['id'], 
            'param1' => $post['object'], 
            'param1_id' => $post['object_id'], 
        )); 
    }

    $array['data']['attachments'] = $attachments; 

    $content = '<!-- CMS-Social Data {{' . serialize(use_filters('ds_mail_serialize_data', $array['data'])) . '}} -->' . "\r"; 
    $content .= $array['content']; 

    db::query("UPDATE comments SET `msg` = '" . $content . "' WHERE id = '" . $post['id'] . "' LIMIT 1"); 
} 



$q = db::query("SELECT * FROM `forum_comments`"); 
while($post = $q->fetch_assoc()) {
    $array = get_text_array($post['msg']); 

    $attachments = array(); 
    foreach($array['data']['attachments'] AS $attach_id) {
        $attach = db::fetch("SELECT * FROM `files_attachments` WHERE `object` = 'forum_comment' AND `object_id` = '" . $post['id'] . "'");
        $file = get_file($attach_id); 

        if (!$attach && $file) {
            $attachments[] = $attach_id; 
        }
    }

    if (!empty($attachments)) {
        add_object_attachments($attachments, array(
            'object' => 'forum_comment', 
            'object_id' => $post['id'], 
            'param1' => $post['object'], 
            'param1_id' => $post['object_id'], 
        )); 
    }

    $array['data']['attachments'] = $attachments; 

    $content = '<!-- CMS-Social Data {{' . serialize(use_filters('ds_mail_serialize_data', $array['data'])) . '}} -->' . "\r"; 
    $content .= $array['content']; 

    db::query("UPDATE forum_comments SET `msg` = '" . $content . "' WHERE id = '" . $post['id'] . "' LIMIT 1"); 
} 
