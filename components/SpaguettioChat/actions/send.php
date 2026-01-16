<?php
/**
 * Send chat message action
 */

if (!ossn_isLoggedin()) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'error' => 'Not logged in'));
    exit;
}

$message = input('message');
$room = input('room', 'main');

if (empty($message)) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'error' => 'Empty message'));
    exit;
}

// Get current user
$user = ossn_loggedin_user();
$username = $user->username;
$user_guid = $user->guid;

// Get room ID
$db = ossn_database();
$room_query = "SELECT id FROM ossn_spaguettio_chat_rooms WHERE name = 'Sala Principal' LIMIT 1";
$room_result = $db->getRow($room_query);
$room_id = $room_result ? $room_result->id : 1;

// Sanitize message
$message = strip_tags($message);
$message = ossn_string_decrypt(ossn_string_encrypt($message)); // Basic sanitization

// Insert message
$time = time();
$insert_query = "INSERT INTO ossn_spaguettio_chat_messages (room_id, user_guid, username, message, type, time_created) 
                 VALUES ({$room_id}, {$user_guid}, '{$username}', '" . $db->escape($message) . "', 'user', {$time})";

if ($db->execute($insert_query)) {
    // Update user's last active time
    $update_user = "UPDATE ossn_spaguettio_chat_users 
                    SET last_active = {$time} 
                    WHERE user_guid = {$user_guid} AND room_id = {$room_id}";
    $db->execute($update_user);
    
    header('Content-Type: application/json');
    echo json_encode(array('success' => true));
} else {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
