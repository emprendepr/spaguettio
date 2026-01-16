<?php
/**
 * Spaguettio Chat Database Schema
 * 
 * Creates necessary tables for chat functionality
 */

function spaguettio_chat_install() {
    $db = new OssnEntities();
    
    // Chat messages table
    $messages_table = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_messages` (
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
    $rooms_table = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_rooms` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `description` text,
        `max_users` int(11) DEFAULT 100,
        `is_active` tinyint(1) DEFAULT 1,
        `time_created` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    // Active users table
    $users_table = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_guid` int(11) NOT NULL,
        `username` varchar(255) NOT NULL,
        `room_id` int(11) NOT NULL DEFAULT 1,
        `last_active` int(11) NOT NULL,
        `time_joined` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_room` (`user_guid`, `room_id`),
        KEY `room_id` (`room_id`),
        KEY `last_active` (`last_active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    // Chat settings table
    $settings_table = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(255) NOT NULL,
        `setting_value` text,
        PRIMARY KEY (`id`),
        UNIQUE KEY `setting_key` (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    // Terms acceptance table
    $terms_table = "CREATE TABLE IF NOT EXISTS `ossn_spaguettio_chat_terms` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_guid` int(11) NOT NULL,
        `username` varchar(255) NOT NULL,
        `accepted` tinyint(1) DEFAULT 1,
        `time_accepted` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_guid` (`user_guid`),
        KEY `time_accepted` (`time_accepted`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    // Execute table creation
    $db->statement($messages_table);
    $db->execute();
    $db->statement($rooms_table);
    $db->execute();
    $db->statement($users_table);
    $db->execute();
    $db->statement($settings_table);
    $db->execute();
    $db->statement($terms_table);
    $db->execute();
    
    // Insert default room
    $default_room = "INSERT INTO `ossn_spaguettio_chat_rooms` (`name`, `description`, `time_created`) 
                     VALUES ('Sala Principal', 'Sala de chat principal de Spaguettio', " . time() . ")
                     ON DUPLICATE KEY UPDATE `name` = `name`;";
    $db->statement($default_room);
    $db->execute();
    
    // Insert default settings
    $default_settings = array(
        array('rate_limit', '10'),
        array('max_users', '100'),
        array('enable_moderation', '1'),
    );
    
    foreach ($default_settings as $setting) {
        $insert_setting = "INSERT INTO `ossn_spaguettio_chat_settings` (`setting_key`, `setting_value`) 
                          VALUES ('" . $setting[0] . "', '" . $setting[1] . "')
                          ON DUPLICATE KEY UPDATE `setting_value` = `setting_value`;";
        $db->statement($insert_setting);
        $db->execute();
    }
    
    return true;
}

function spaguettio_chat_uninstall() {
    $db = new OssnEntities();
    
    $db->statement("DROP TABLE IF EXISTS `ossn_spaguettio_chat_messages`;");
    $db->execute();
    $db->statement("DROP TABLE IF EXISTS `ossn_spaguettio_chat_rooms`;");
    $db->execute();
    $db->statement("DROP TABLE IF EXISTS `ossn_spaguettio_chat_users`;");
    $db->execute();
    $db->statement("DROP TABLE IF EXISTS `ossn_spaguettio_chat_settings`;");
    $db->execute();
    $db->statement("DROP TABLE IF EXISTS `ossn_spaguettio_chat_terms`;");
    $db->execute();
    
    return true;
}
