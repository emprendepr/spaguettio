<?php
/**
 * Save settings action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('success' => false, 'error' => 'Not authorized'));
    exit;
}

$room_name = input('room_name');
$max_users = input('max_users', 100);
$rate_limit = input('rate_limit', 10);
$enable_moderation = input('enable_moderation') ? 1 : 0;

$db = new OssnDatabase();

// Update settings
$settings = array(
    'max_users' => $max_users,
    'rate_limit' => $rate_limit,
    'enable_moderation' => $enable_moderation
);

$success = true;
foreach ($settings as $key => $value) {
    $query = "INSERT INTO ossn_spaguettio_chat_settings (setting_key, setting_value)
              VALUES ('{$key}', '{$value}')
              ON DUPLICATE KEY UPDATE setting_value = '{$value}'";
    
    if (!$db->execute($query)) {
        $success = false;
    }
}

if ($success) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
