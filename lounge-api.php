<?php
session_start();

// Constantes
define('MESSAGES_FILE', 'lounge_messages.json');
define('USERS_FILE', 'lounge_users.json');
define('COUNTER_FILE', 'lounge_counter.json');

// Header JSON
header('Content-Type: application/json');

// Inicializar archivos si no existen
if (!file_exists(MESSAGES_FILE)) {
    $fp = fopen(MESSAGES_FILE, 'c');
    if (flock($fp, LOCK_EX)) {
        if (filesize(MESSAGES_FILE) == 0) {
            fwrite($fp, json_encode([]));
        }
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

if (!file_exists(USERS_FILE)) {
    $fp = fopen(USERS_FILE, 'c');
    if (flock($fp, LOCK_EX)) {
        if (filesize(USERS_FILE) == 0) {
            fwrite($fp, json_encode([]));
        }
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

if (!file_exists(COUNTER_FILE)) {
    $fp = fopen(COUNTER_FILE, 'c');
    if (flock($fp, LOCK_EX)) {
        if (filesize(COUNTER_FILE) == 0) {
            fwrite($fp, json_encode(['message_id' => 0]));
        }
        flock($fp, LOCK_UN);
    }
    fclose($fp);
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
    $fp = fopen(USERS_FILE, 'c+');
    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return;
    }
    
    $content = fread($fp, filesize(USERS_FILE) ?: 1);
    $users = json_decode($content ?: '[]', true);
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
    
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode(array_values($users)));
    flock($fp, LOCK_UN);
    fclose($fp);
}

// Actualizar actividad del usuario
updateUserActivity();

// Obtener acción
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'send':
        $message = trim($_POST['message'] ?? '');
        
        // Validación y sanitización
        if (empty($message)) {
            echo json_encode(['error' => 'Mensaje vacío']);
            exit;
        }
        
        // Limitar longitud del mensaje
        if (strlen($message) > 500) {
            echo json_encode(['error' => 'Mensaje muy largo (máximo 500 caracteres)']);
            exit;
        }
        
        // Sanitizar el mensaje
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        
        // Obtener nuevo ID con file locking
        $fpCounter = fopen(COUNTER_FILE, 'c+');
        flock($fpCounter, LOCK_EX);
        $counterContent = fread($fpCounter, filesize(COUNTER_FILE) ?: 1);
        $counter = json_decode($counterContent ?: '{"message_id":0}', true);
        $newId = ++$counter['message_id'];
        ftruncate($fpCounter, 0);
        rewind($fpCounter);
        fwrite($fpCounter, json_encode($counter));
        flock($fpCounter, LOCK_UN);
        fclose($fpCounter);
        
        // Leer y actualizar mensajes con file locking
        $fp = fopen(MESSAGES_FILE, 'c+');
        flock($fp, LOCK_EX);
        $content = fread($fp, filesize(MESSAGES_FILE) ?: 1);
        $messages = json_decode($content ?: '[]', true);
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $newMessage = [
            'id' => $newId,
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
        
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($messages));
        flock($fp, LOCK_UN);
        fclose($fp);
        
        echo json_encode(['success' => true]);
        break;
    
    case 'get_messages':
        $lastId = intval($_GET['last_id'] ?? 0);
        
        $fp = fopen(MESSAGES_FILE, 'r');
        if (flock($fp, LOCK_SH)) {
            $content = fread($fp, filesize(MESSAGES_FILE) ?: 1);
            $messages = json_decode($content ?: '[]', true);
            flock($fp, LOCK_UN);
        } else {
            $messages = [];
        }
        fclose($fp);
        
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $newMessages = array_filter($messages, function($msg) use ($lastId) {
            return $msg['id'] > $lastId;
        });
        
        echo json_encode(['messages' => array_values($newMessages)]);
        break;
    
    case 'get_users':
        $fp = fopen(USERS_FILE, 'r');
        if (flock($fp, LOCK_SH)) {
            $content = fread($fp, filesize(USERS_FILE) ?: 1);
            $users = json_decode($content ?: '[]', true);
            flock($fp, LOCK_UN);
        } else {
            $users = [];
        }
        fclose($fp);
        
        if (!is_array($users)) {
            $users = [];
        }
        
        echo json_encode(['users' => array_values($users)]);
        break;
    
    case 'change_name':
        $newName = trim($_POST['new_name'] ?? '');
        
        // Validación y sanitización
        if (empty($newName)) {
            echo json_encode(['error' => 'Nombre vacío']);
            exit;
        }
        
        // Limitar longitud del nombre
        if (strlen($newName) > 50) {
            echo json_encode(['error' => 'Nombre muy largo (máximo 50 caracteres)']);
            exit;
        }
        
        // Sanitizar el nombre
        $newName = htmlspecialchars($newName, ENT_QUOTES, 'UTF-8');
        
        $oldName = $_SESSION['username'];
        $_SESSION['username'] = $newName;
        
        // Obtener nuevo ID con file locking
        $fpCounter = fopen(COUNTER_FILE, 'c+');
        flock($fpCounter, LOCK_EX);
        $counterContent = fread($fpCounter, filesize(COUNTER_FILE) ?: 1);
        $counter = json_decode($counterContent ?: '{"message_id":0}', true);
        $newId = ++$counter['message_id'];
        ftruncate($fpCounter, 0);
        rewind($fpCounter);
        fwrite($fpCounter, json_encode($counter));
        flock($fpCounter, LOCK_UN);
        fclose($fpCounter);
        
        // Agregar mensaje de sistema
        $fp = fopen(MESSAGES_FILE, 'c+');
        flock($fp, LOCK_EX);
        $content = fread($fp, filesize(MESSAGES_FILE) ?: 1);
        $messages = json_decode($content ?: '[]', true);
        if (!is_array($messages)) {
            $messages = [];
        }
        
        $systemMessage = [
            'id' => $newId,
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
        
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($messages));
        flock($fp, LOCK_UN);
        fclose($fp);
        
        echo json_encode(['success' => true]);
        break;
    
    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
?>
