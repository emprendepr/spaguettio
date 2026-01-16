<?php
/**
 * Lounge - Acción para obtener mensajes
 */

$lastId = input('last_id', 0);

$messages = lounge_load_messages();

// Filtrar mensajes nuevos
$newMessages = array_filter($messages, function($msg) use ($lastId) {
    return $msg['id'] > $lastId;
});

// Reindexar array
$newMessages = array_values($newMessages);

// Actualizar actividad del usuario
lounge_update_user_activity();

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'messages' => $newMessages
]);
