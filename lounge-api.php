<?php
session_start();

// Constantes
define('MESSAGES_FILE', 'lounge_messages.json');
define('USERS_FILE', 'lounge_users.json');

// Header JSON
header('Content-Type: application/json');

// Inicializar archivos si no existen
if (!file_exists(MESSAGES_FILE)) {
    file_put_contents(MESSAGES_FILE, json_encode([]));
}

if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode([]));
}

// Generar nombre de usuario si no existe
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Usuario' . rand(1000, 9999);
}

// Generar color aleatorio si no existe
if (!isset($_SESSION['user_color'])) {
    $_SESSION['user_color'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

// Función para actualizar actividad del usuario
function updateUserActivity() {
    $users = json_decode(file_get_contents(USERS_FILE), true);
    if (!is_array($users)) {
        $users = [];
    }
    
    $currentTime = time();
    $username = $_SESSION['username'];
    $userColor = $_SESSION['user_color'];
    
    // Actualizar o agregar usuario actual
    $found = false;
    foreach ($users as &$user) {
        if ($user['username'] === $username) {
            $user['last_activity'] = $currentTime;
            $user['color'] = $userColor;
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        $users[] = [
            'username' => $username,
            'color' => $userColor,
            'last_activity' => $currentTime
        ];
    }
    
    // Limpiar usuarios inactivos (más de 30 segundos)
    $users = array_filter($users, function($user) use ($currentTime) {
        return ($currentTime - $user['last_activity']) <= 30;
    });
    
    file_put_contents(USERS_FILE, json_encode(array_values($users)));
}

// Actualizar actividad del usuario
updateUserActivity();

// Obtener acción
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'send':
        $message = trim($_POST['message'] ?? '');
        
        if (empty($message)) {
            echo json_encode(['error' => 'Mensaje vacío']);
            exit;
        }
        
        $messages = json_decode(file_get_contents(MESSAGES_FILE), true);
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $newMessage = [
            'id' => count($messages) + 1,
            'username' => $_SESSION['username'],
            'color' => $_SESSION['user_color'],
            'message' => $message,
            'time' => date('H:i'),
            'timestamp' => time(),
            'type' => 'user'
        ];
        
        $messages[] = $newMessage;
        
        // Mantener solo los últimos 100 mensajes
        if (count($messages) > 100) {
            $messages = array_slice($messages, -100);
        }
        
        file_put_contents(MESSAGES_FILE, json_encode($messages));
        
        echo json_encode(['success' => true]);
        break;
    
    case 'get_messages':
        $lastId = intval($_GET['last_id'] ?? 0);
        
        $messages = json_decode(file_get_contents(MESSAGES_FILE), true);
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $newMessages = array_filter($messages, function($msg) use ($lastId) {
            return $msg['id'] > $lastId;
        });
        
        echo json_encode(['messages' => array_values($newMessages)]);
        break;
    
    case 'get_users':
        $users = json_decode(file_get_contents(USERS_FILE), true);
        if (!is_array($users)) {
            $users = [];
        }
        
        echo json_encode(['users' => array_values($users)]);
        break;
    
    case 'change_name':
        $newName = trim($_POST['new_name'] ?? '');
        
        if (empty($newName)) {
            echo json_encode(['error' => 'Nombre vacío']);
            exit;
        }
        
        $oldName = $_SESSION['username'];
        $_SESSION['username'] = $newName;
        
        // Agregar mensaje de sistema
        $messages = json_decode(file_get_contents(MESSAGES_FILE), true);
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $systemMessage = [
            'id' => count($messages) + 1,
            'message' => "$oldName ahora se llama $newName",
            'time' => date('H:i'),
            'timestamp' => time(),
            'type' => 'system'
        ];
        
        $messages[] = $systemMessage;
        
        // Mantener solo los últimos 100 mensajes
        if (count($messages) > 100) {
            $messages = array_slice($messages, -100);
        }
        
        file_put_contents(MESSAGES_FILE, json_encode($messages));
        
        echo json_encode(['success' => true]);
        break;
    
    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
?>
