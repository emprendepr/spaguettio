<?php
/**
 * Accept or decline chat terms action
 */

if (!ossn_isLoggedin()) {
    redirect(ossn_site_url('login'));
    exit;
}

$action = input('action');

// Get current user
$user = ossn_loggedin_user();
$username = $user->username;
$user_guid = $user->guid;

if ($action === 'decline') {
    // User declined terms, redirect to homepage
    redirect(ossn_site_url());
    exit;
}

if ($action === 'accept') {
    // User accepted terms, record in database
    try {
        $db = new OssnEntities();
        $time = time();
        
        // Escape username for SQL
        $username_escaped = $db->escape($username);
        
        // Insert or update terms acceptance
        $query = "INSERT INTO ossn_spaguettio_chat_terms (user_guid, username, accepted, time_accepted)
                  VALUES ({$user_guid}, '{$username_escaped}', 1, {$time})
                  ON DUPLICATE KEY UPDATE accepted = 1, time_accepted = {$time}";
        
        $db->statement($query);
        
        if ($db->execute()) {
            // Success - redirect to chat room
            ossn_trigger_message(ossn_print('spaguettio:chat:terms:accepted'), 'success');
            redirect(ossn_site_url('chat/room'));
            exit;
        } else {
            // Database error
            ossn_trigger_message(ossn_print('spaguettio:chat:error:terms'), 'error');
            redirect(ossn_site_url('chat/terms'));
            exit;
        }
    } catch (Exception $e) {
        // Exception occurred
        ossn_trigger_message(ossn_print('spaguettio:chat:error:database'), 'error');
        redirect(ossn_site_url('chat/terms'));
        exit;
    }
} else {
    // Invalid action
    redirect(ossn_site_url());
    exit;
}
