<?php
/**
 * Clear history action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('success' => false, 'error' => 'Not authorized'));
    exit;
}

$db = ossn_database();

// Clear all messages
$query = "DELETE FROM ossn_spaguettio_chat_messages";

if ($db->execute($query)) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
