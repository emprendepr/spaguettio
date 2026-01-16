<?php
/**
 * Get online users action
 */

header('Content-Type: application/json');

if (!ossn_isLoggedin()) {
    echo json_encode(array('users' => array()));
    exit;
}

$room = input('room', 'main');

// Get room ID
$db = ossn_database();
$room_query = "SELECT id FROM ossn_spaguettio_chat_rooms WHERE name = 'Sala Principal' LIMIT 1";
$room_result = $db->getRow($room_query);
$room_id = $room_result ? $room_result->id : 1;

// Remove inactive users (inactive for more than 5 minutes)
$timeout = time() - 300;
$cleanup_query = "DELETE FROM ossn_spaguettio_chat_users WHERE last_active < {$timeout}";
$db->execute($cleanup_query);

// Get active users
$query = "SELECT cu.username, cu.user_guid, u.icon_url
          FROM ossn_spaguettio_chat_users cu
          LEFT JOIN ossn_users u ON cu.user_guid = u.guid
          WHERE cu.room_id = {$room_id} AND cu.last_active >= {$timeout}
          ORDER BY cu.username ASC";

$users = $db->getAll($query);
$result = array();

if ($users) {
    foreach ($users as $user) {
        $avatar = ossn_site_url() . 'avatar/' . $user->username . '/small';
        if ($user->icon_url) {
            $avatar = $user->icon_url;
        }
        
        $result[] = array(
            'username' => $user->username,
            'avatar' => $avatar
        );
    }
}

echo json_encode(array('users' => $result));
