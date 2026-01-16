<?php
/**
 * Create room action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('success' => false, 'error' => 'Not authorized'));
    exit;
}

$name = input('name');
$description = input('description', '');
$max_users = input('max_users', 100);

if (empty($name)) {
    echo json_encode(array('success' => false, 'error' => 'Room name required'));
    exit;
}

$db = new OssnDatabase();
$time = time();

// Insert new room
$query = "INSERT INTO ossn_spaguettio_chat_rooms (name, description, max_users, time_created)
          VALUES ('" . $db->escape($name) . "', '" . $db->escape($description) . "', {$max_users}, {$time})";

if ($db->execute($query)) {
    echo json_encode(array('success' => true, 'room_id' => $db->lastInsertId()));
} else {
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
