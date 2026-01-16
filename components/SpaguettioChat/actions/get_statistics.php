<?php
/**
 * Get statistics action (for admin)
 */

header('Content-Type: application/json');

if (!ossn_isAdminLoggedin()) {
    echo json_encode(array());
    exit;
}

$db = new OssnEntities();

// Get online users count
$timeout = time() - 300;
$online_query = "SELECT COUNT(DISTINCT user_guid) as count FROM ossn_spaguettio_chat_users WHERE last_active >= {$timeout}";
$db->statement($online_query);
$db->execute();
$online_result = $db->fetch();
$online_users = $online_result ? $online_result->count : 0;

// Get messages today
$today_start = strtotime('today');
$messages_query = "SELECT COUNT(*) as count FROM ossn_spaguettio_chat_messages WHERE time_created >= {$today_start}";
$db->statement($messages_query);
$db->execute();
$messages_result = $db->fetch();
$messages_today = $messages_result ? $messages_result->count : 0;

// Get average users (last 7 days)
$week_ago = time() - (7 * 24 * 60 * 60);
$avg_query = "SELECT AVG(daily_users) as avg FROM (
                SELECT DATE(FROM_UNIXTIME(time_joined)) as day, COUNT(DISTINCT user_guid) as daily_users
                FROM ossn_spaguettio_chat_users
                WHERE time_joined >= {$week_ago}
                GROUP BY day
              ) as daily_stats";
$db->statement($avg_query);
$db->execute();
$avg_result = $db->fetch();
$avg_users = $avg_result && $avg_result->avg ? round($avg_result->avg) : 0;

echo json_encode(array(
    'online_users' => $online_users,
    'messages_today' => $messages_today,
    'avg_users' => $avg_users
));
