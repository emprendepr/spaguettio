<?php
/**
 * Delete room action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('success' => false, 'error' => 'Not authorized'));
    exit;
}

$room_id = input('room_id');

if (empty($room_id) || $room_id == 1) {
    echo json_encode(array('success' => false, 'error' => 'Cannot delete main room'));
    exit;
}

$db = new OssnEntities();

// Delete room users
$db->statement("DELETE FROM ossn_spaguettio_chat_users WHERE room_id = {$room_id}");
$db->execute();

// Delete room messages
$db->statement("DELETE FROM ossn_spaguettio_chat_messages WHERE room_id = {$room_id}");
$db->execute();

// Delete room
$query = "DELETE FROM ossn_spaguettio_chat_rooms WHERE id = {$room_id}";

$db->statement($query);
if ($db->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
