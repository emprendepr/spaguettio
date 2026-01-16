<?php
/**
 * Register user in chat action
 */

header('Content-Type: application/json');

if (!ossn_isLoggedin()) {
    echo json_encode(array('success' => false));
    exit;
}

$room = input('room', 'main');

// Get current user
$user = ossn_loggedin_user();
$username = $user->username;
$user_guid = $user->guid;

// Get room ID
$db = new OssnEntities();
$db->statement("SELECT id FROM ossn_spaguettio_chat_rooms WHERE name = 'Sala Principal' LIMIT 1");
$db->execute();
$room_result = $db->fetch();
$room_id = $room_result ? $room_result->id : 1;

$time = time();

// Insert or update user in chat
$insert_query = "INSERT INTO ossn_spaguettio_chat_users (user_guid, username, room_id, last_active, time_joined)
                 VALUES ({$user_guid}, '{$username}', {$room_id}, {$time}, {$time})
                 ON DUPLICATE KEY UPDATE last_active = {$time}";

$db->statement($insert_query);
if ($db->execute()) {
    // Add system message
    $join_message = "{$username} " . ossn_print('spaguettio:chat:joined');
    $system_query = "INSERT INTO ossn_spaguettio_chat_messages (room_id, user_guid, username, message, type, time_created)
                     VALUES ({$room_id}, {$user_guid}, '{$username}', '" . $db->escape($join_message) . "', 'system', {$time})";
    $db->statement($system_query);
    $db->execute();
    
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}
