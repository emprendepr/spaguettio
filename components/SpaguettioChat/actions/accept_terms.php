<?php
/**
 * Accept or decline chat terms action
 * 
 * This action handles both AJAX and non-AJAX requests.
 * For AJAX: Returns JSON with redirect URL
 * For non-AJAX: Redirects directly
 */

if (!ossn_isLoggedin()) {
    if (ossn_is_xhr()) {
        echo json_encode(array('error' => true, 'redirect' => ossn_site_url('login')));
    } else {
        redirect('login');
    }
    exit;
}

$action = input('action');

// Get current user
$user = ossn_loggedin_user();
$username = $user->username;
$user_guid = $user->guid;

if ($action === 'decline') {
    // User declined terms, redirect to homepage
    if (ossn_is_xhr()) {
        global $Ossn;
        $Ossn->redirect = ossn_site_url();
        echo json_encode(array('success' => true, 'redirect' => ossn_site_url()));
    } else {
        redirect();
    }
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
            if (ossn_is_xhr()) {
                global $Ossn;
                $Ossn->redirect = ossn_site_url('chat/room');
            } else {
                redirect('chat/room');
            }
        } else {
            // Database error
            ossn_trigger_message(ossn_print('spaguettio:chat:error:terms'), 'error');
            if (ossn_is_xhr()) {
                global $Ossn;
                $Ossn->redirect = ossn_site_url('chat/terms');
            } else {
                redirect('chat/terms');
            }
        }
    } catch (Exception $e) {
        // Exception occurred
        ossn_trigger_message(ossn_print('spaguettio:chat:error:database'), 'error');
        if (ossn_is_xhr()) {
            global $Ossn;
            $Ossn->redirect = ossn_site_url('chat/terms');
        } else {
            redirect('chat/terms');
        }
    }
    exit;
}

// Invalid action - redirect to homepage
if (ossn_is_xhr()) {
    global $Ossn;
    $Ossn->redirect = ossn_site_url();
} else {
    redirect();
}
exit;
