<?php
/**
 * Unregister user from chat action
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
$db = new OssnDatabase();
$room_query = "SELECT id FROM ossn_spaguettio_chat_rooms WHERE name = 'Sala Principal' LIMIT 1";
$room_result = $db->getRow($room_query);
$room_id = $room_result ? $room_result->id : 1;

// Remove user from chat
$delete_query = "DELETE FROM ossn_spaguettio_chat_users 
                 WHERE user_guid = {$user_guid} AND room_id = {$room_id}";

if ($db->execute($delete_query)) {
    // Add system message
    $time = time();
    $leave_message = "{$username} " . ossn_print('spaguettio:chat:left');
    $system_query = "INSERT INTO ossn_spaguettio_chat_messages (room_id, user_guid, username, message, type, time_created)
                     VALUES ({$room_id}, {$user_guid}, '{$username}', '" . $db->escape($leave_message) . "', 'system', {$time})";
    $db->execute($system_query);
    
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}
