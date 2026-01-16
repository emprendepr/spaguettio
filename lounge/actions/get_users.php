<?php
/**
 * Lounge - Acción para obtener usuarios activos
 */

$userTimeout = 30; // segundos

$users = lounge_load_users();
$currentTime = time();
$activeUsers = [];

// Filtrar usuarios activos y limpiar inactivos
foreach ($users as $sessionId => $user) {
    if ($currentTime - $user['last_activity'] <= $userTimeout) {
        $activeUsers[] = [
            'username' => $user['username'],
            'color' => $user['color']
        ];
    } else {
        // Eliminar usuario inactivo
        unset($users[$sessionId]);
    }
}

// Guardar usuarios actualizados
lounge_save_users($users);

// Actualizar actividad del usuario actual
lounge_update_user_activity();

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'users' => $activeUsers
]);
