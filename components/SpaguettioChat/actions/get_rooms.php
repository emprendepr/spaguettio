<?php
/**
 * Get rooms action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('rooms' => array()));
    exit;
}

$db = new OssnDatabase();

// Get all rooms with user counts
$query = "SELECT r.id, r.name, r.description, r.max_users, r.is_active, r.time_created,
          COUNT(DISTINCT cu.user_guid) as user_count
          FROM ossn_spaguettio_chat_rooms r
          LEFT JOIN ossn_spaguettio_chat_users cu ON r.id = cu.room_id
          GROUP BY r.id
          ORDER BY r.time_created DESC";

$rooms = $db->getAll($query);
$result = array();

if ($rooms) {
    foreach ($rooms as $room) {
        $result[] = array(
            'id' => $room->id,
            'name' => $room->name,
            'description' => $room->description,
            'max_users' => $room->max_users,
            'is_active' => $room->is_active,
            'user_count' => $room->user_count,
            'time_created' => $room->time_created
        );
    }
}

echo json_encode(array('rooms' => $result));
