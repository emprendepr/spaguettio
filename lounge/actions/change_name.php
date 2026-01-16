<?php
/**
 * Lounge - Acción para cambiar nombre de usuario
 */

$newName = input('new_name');

if (empty($newName)) {
    echo json_encode(['success' => false, 'error' => 'Empty name']);
    exit;
}

// Validar nombre
if (strlen($newName) > 30) {
    echo json_encode(['success' => false, 'error' => 'Name too long']);
    exit;
}

if (!preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑüÜ\s]+$/', $newName)) {
    echo json_encode(['success' => false, 'error' => 'Invalid characters in name']);
    exit;
}

$oldName = $_SESSION['lounge_username'];
$_SESSION['lounge_username'] = $newName;

// Crear mensaje de sistema
$messages = lounge_load_messages();

$systemMessage = [
    'id' => count($messages) > 0 ? max(array_column($messages, 'id')) + 1 : 1,
    'username' => 'Sistema',
    'color' => '#000000',
    'message' => sprintf(ossn_print('lounge:system:namechange'), $oldName, $newName),
    'time' => date('H:i'),
    'timestamp' => time(),
    'type' => 'system'
];

$messages[] = $systemMessage;
lounge_save_messages($messages);

// Actualizar usuario en la lista
lounge_update_user_activity();

echo json_encode(['success' => true]);
