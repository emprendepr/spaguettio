<?php
/**
 * Edit room action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('success' => false, 'error' => 'Not authorized'));
    exit;
}

$room_id = input('room_id');
$name = input('name');
$description = input('description', '');
$max_users = input('max_users', 100);

if (empty($room_id) || empty($name)) {
    echo json_encode(array('success' => false, 'error' => 'Room ID and name required'));
    exit;
}

$db = new OssnEntities();

// Update room
$query = "UPDATE ossn_spaguettio_chat_rooms 
          SET name = '" . $db->escape($name) . "',
              description = '" . $db->escape($description) . "',
              max_users = {$max_users}
          WHERE id = {$room_id}";

$db->statement($query);
if ($db->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
