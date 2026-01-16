<?php
/**
 * Clear history action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array('success' => false, 'error' => 'Not authorized'));
    exit;
}

$db = new OssnEntities();

// Clear all messages
$query = "DELETE FROM ossn_spaguettio_chat_messages";

$db->statement($query);
if ($db->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Database error'));
}
