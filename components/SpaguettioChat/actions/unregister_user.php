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
$db->statement("SELECT id FROM ossn_spaguettio_chat_rooms WHERE name = 'Sala Principal' LIMIT 1");
$db->execute();
$room_result = $db->fetch();
$room_id = $room_result ? $room_result->id : 1;

// Remove user from chat
$delete_query = "DELETE FROM ossn_spaguettio_chat_users 
                 WHERE user_guid = {$user_guid} AND room_id = {$room_id}";

$db->statement($delete_query);
if ($db->execute()) {
    // Add system message
    $time = time();
    $leave_message = "{$username} " . ossn_print('spaguettio:chat:left');
    $system_query = "INSERT INTO ossn_spaguettio_chat_messages (room_id, user_guid, username, message, type, time_created)
                     VALUES ({$room_id}, {$user_guid}, '{$username}', '" . $db->escape($leave_message) . "', 'system', {$time})";
    $db->statement($system_query);
    $db->execute();
    $db->execute($system_query);
    
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}
