<?php
/**
 * Lounge - Acción para enviar mensaje
 */

$message = input('message');

if (empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Empty message']);
    exit;
}

// Validar longitud
if (strlen($message) > 500) {
    echo json_encode(['success' => false, 'error' => 'Message too long']);
    exit;
}

// Cargar mensajes existentes
$messages = lounge_load_messages();

// Crear nuevo mensaje
$newMessage = [
    'id' => count($messages) > 0 ? max(array_column($messages, 'id')) + 1 : 1,
    'username' => $_SESSION['lounge_username'],
    'color' => $_SESSION['lounge_color'],
    'message' => $message,
    'time' => date('H:i'),
    'timestamp' => time(),
    'type' => 'user'
];

$messages[] = $newMessage;

// Limitar a los últimos 100 mensajes
if (count($messages) > 100) {
    $messages = array_slice($messages, -100);
}

// Guardar mensajes
lounge_save_messages($messages);

// Actualizar actividad del usuario
lounge_update_user_activity();

echo json_encode(['success' => true]);
