<?php
/**
 * Get chat messages action
 */

header('Content-Type: application/json');

if (!ossn_isLoggedin()) {
    echo json_encode(array('messages' => array()));
    exit;
}

$room = input('room', 'main');
$last_id = input('last_id', 0);

// Get room ID
$db = new OssnDatabase();
$db->statement("SELECT id FROM ossn_spaguettio_chat_rooms WHERE name = 'Sala Principal' LIMIT 1");
$db->execute();
$room_result = $db->fetch();
$room_id = $room_result ? $room_result->id : 1;

// Get messages
$query = "SELECT m.*, u.icon_url as user_icon 
          FROM ossn_spaguettio_chat_messages m
          LEFT JOIN ossn_users u ON m.user_guid = u.guid
          WHERE m.room_id = {$room_id} AND m.id > {$last_id}
          ORDER BY m.time_created ASC
          LIMIT 50";

$db->statement($query);
$db->execute();
$messages = $db->fetch(true);
$result = array();

if ($messages) {
    foreach ($messages as $msg) {
        $avatar = ossn_site_url() . 'avatar/' . $msg->username . '/small';
        if ($msg->user_icon) {
            $avatar = $msg->user_icon;
        }
        
        $result[] = array(
            'id' => $msg->id,
            'username' => $msg->username,
            'message' => $msg->message,
            'type' => $msg->type,
            'time_created' => $msg->time_created,
            'user_avatar' => $avatar
        );
    }
}

echo json_encode(array('messages' => $result));
