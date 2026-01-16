<?php
/**
 * Spaguettio Chat Component
 * Database setup when component is enabled
 *
 * @package   Spaguettio Chat
 * @author    Spaguettio Team
 * @license   Open Source Social Network License (OSSN LICENSE)
 * @link      https://www.opensource-socialnetwork.org/
 */

$component = new OssnEntities;

// Chat messages table
$query1 = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_messages` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `room_id` int(11) NOT NULL DEFAULT 1,
    `user_guid` int(11) NOT NULL,
    `username` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `type` enum('user','system') DEFAULT 'user',
    `time_created` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `room_id` (`room_id`),
    KEY `user_guid` (`user_guid`),
    KEY `time_created` (`time_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Chat rooms table
$query2 = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_rooms` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text,
    `max_users` int(11) DEFAULT 100,
    `is_active` tinyint(1) DEFAULT 1,
    `time_created` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Chat active users table
$query3 = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_guid` int(11) NOT NULL,
    `username` varchar(255) NOT NULL,
    `room_id` int(11) NOT NULL DEFAULT 1,
    `last_active` int(11) NOT NULL,
    `time_joined` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_room` (`user_guid`, `room_id`),
    KEY `last_active` (`last_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Chat settings table
$query4 = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `setting_key` varchar(255) NOT NULL,
    `setting_value` text,
    PRIMARY KEY (`id`),
    UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Terms acceptance table
$query5 = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_terms` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_guid` int(11) NOT NULL,
    `username` varchar(255) NOT NULL,
    `accepted` tinyint(1) DEFAULT 0,
    `time_accepted` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_guid` (`user_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Execute table creation
$component->statement($query1);
$component->execute();
$component->statement($query2);
$component->execute();
$component->statement($query3);
$component->execute();
$component->statement($query4);
$component->execute();
$component->statement($query5);
$component->execute();

// Insert default room if not exists
$check_room = "SELECT COUNT(*) as count FROM ossn_spaguettio_chat_rooms WHERE id = 1";
$component->statement($check_room);
$component->execute();
$result = $component->fetch();

if (!$result || $result->count == 0) {
    $default_room = "INSERT INTO `ossn_spaguettio_chat_rooms` (`id`, `name`, `description`, `time_created`) 
                     VALUES (1, 'Sala Principal', 'Sala de chat principal de Spaguettio', " . time() . ")";
    $component->statement($default_room);
    $component->execute();
}

// Insert default settings if they don't exist
$default_settings = array(
    array('max_users', '100'),
    array('rate_limit', '10'),
    array('enable_moderation', '0')
);

foreach ($default_settings as $setting) {
    $check_setting = "SELECT COUNT(*) as count FROM ossn_spaguettio_chat_settings WHERE setting_key = '{$setting[0]}'";
    $component->statement($check_setting);
    $component->execute();
    $result = $component->fetch();
    
    if (!$result || $result->count == 0) {
        $insert_setting = "INSERT INTO `ossn_spaguettio_chat_settings` (`setting_key`, `setting_value`) 
                          VALUES ('{$setting[0]}', '{$setting[1]}')";
        $component->statement($insert_setting);
        $component->execute();
    }
}
