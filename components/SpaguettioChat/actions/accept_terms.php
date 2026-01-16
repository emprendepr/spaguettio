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
    $db = new OssnDatabase();
    $time = time();
    
    // Insert or update terms acceptance
    $query = "INSERT INTO ossn_spaguettio_chat_terms (user_guid, username, accepted, time_accepted)
              VALUES ({$user_guid}, '{$username}', 1, {$time})
              ON DUPLICATE KEY UPDATE accepted = 1, time_accepted = {$time}";
    
    if ($db->execute($query)) {
        // Redirect to chat room
        redirect(ossn_site_url('chat/room'));
    } else {
        // Error occurred
        ossn_trigger_message(ossn_print('spaguettio:chat:error:terms'), 'error');
        redirect(ossn_site_url('chat'));
    }
} else {
    // Invalid action
    redirect(ossn_site_url());
}
