<?php
session_start();

// Configuración
$messagesFile = __DIR__ . '/chat_messages.json';
$usersFile = __DIR__ . '/chat_users.json';
$maxMessages = 100;
$userTimeout = 30; // segundos

// Headers para JSON
header('Content-Type: application/json');

// Obtener acción
$action = $_REQUEST['action'] ?? '';

// Procesar acción
switch ($action) {
    case 'send':
        sendMessage();
        break;
    case 'get_messages':
        getMessages();
        break;
    case 'get_users':
        getUsers();
        break;
    case 'change_name':
        changeName();
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}

/**
 * Enviar nuevo mensaje
 */
function sendMessage() {
    global $messagesFile, $maxMessages;
    
    if (!isset($_SESSION['username']) || !isset($_POST['message'])) {
        echo json_encode(['success' => false, 'error' => 'Missing data']);
        return;
    }
    
    $message = trim($_POST['message']);
    
    if (empty($message)) {
        echo json_encode(['success' => false, 'error' => 'Empty message']);
        return;
    }
    
    // Cargar mensajes existentes
    $messages = loadMessages();
    
    // Crear nuevo mensaje
    $newMessage = [
        'id' => count($messages) > 0 ? max(array_column($messages, 'id')) + 1 : 1,
        'username' => $_SESSION['username'],
        'color' => $_SESSION['color'],
        'message' => $message,
        'time' => date('H:i'),
        'timestamp' => time(),
        'type' => 'user'
    ];
    
    $messages[] = $newMessage;
    
    // Limitar a los últimos N mensajes
    if (count($messages) > $maxMessages) {
        $messages = array_slice($messages, -$maxMessages);
    }
    
    // Guardar mensajes
    saveMessages($messages);
    
    // Actualizar actividad del usuario
    updateUserActivity();
    
    echo json_encode(['success' => true]);
}

/**
 * Obtener mensajes nuevos
 */
function getMessages() {
    $lastId = isset($_GET['last_id']) ? intval($_GET['last_id']) : 0;
    
    $messages = loadMessages();
    
    // Filtrar mensajes nuevos
    $newMessages = array_filter($messages, function($msg) use ($lastId) {
        return $msg['id'] > $lastId;
    });
    
    // Reindexar array
    $newMessages = array_values($newMessages);
    
    // Actualizar actividad del usuario
    updateUserActivity();
    
    echo json_encode([
        'success' => true,
        'messages' => $newMessages
    ]);
}

/**
 * Obtener usuarios activos
 */
function getUsers() {
    global $userTimeout;
    
    $users = loadUsers();
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
    saveUsers($users);
    
    // Actualizar actividad del usuario actual
    updateUserActivity();
    
    echo json_encode([
        'success' => true,
        'users' => $activeUsers
    ]);
}

/**
 * Cambiar nombre de usuario
 */
function changeName() {
    global $messagesFile;
    
    if (!isset($_POST['new_name'])) {
        echo json_encode(['success' => false, 'error' => 'Missing name']);
        return;
    }
    
    $newName = trim($_POST['new_name']);
    
    if (empty($newName)) {
        echo json_encode(['success' => false, 'error' => 'Empty name']);
        return;
    }
    
    $oldName = $_SESSION['username'];
    $_SESSION['username'] = $newName;
    
    // Crear mensaje de sistema
    $messages = loadMessages();
    
    $systemMessage = [
        'id' => count($messages) > 0 ? max(array_column($messages, 'id')) + 1 : 1,
        'username' => 'Sistema',
        'color' => '#000000',
        'message' => "$oldName ahora se llama $newName",
        'time' => date('H:i'),
        'timestamp' => time(),
        'type' => 'system'
    ];
    
    $messages[] = $systemMessage;
    saveMessages($messages);
    
    // Actualizar usuario en la lista
    updateUserActivity();
    
    echo json_encode(['success' => true]);
}

/**
 * Actualizar actividad del usuario
 */
function updateUserActivity() {
    if (!isset($_SESSION['username'])) {
        return;
    }
    
    $users = loadUsers();
    $sessionId = session_id();
    
    $users[$sessionId] = [
        'username' => $_SESSION['username'],
        'color' => $_SESSION['color'],
        'last_activity' => time()
    ];
    
    saveUsers($users);
}

/**
 * Cargar mensajes desde archivo
 */
function loadMessages() {
    global $messagesFile;
    
    if (!file_exists($messagesFile)) {
        return [];
    }
    
    $content = file_get_contents($messagesFile);
    $messages = json_decode($content, true);
    
    return is_array($messages) ? $messages : [];
}

/**
 * Guardar mensajes en archivo
 */
function saveMessages($messages) {
    global $messagesFile;
    
    $json = json_encode($messages, JSON_PRETTY_PRINT);
    file_put_contents($messagesFile, $json);
}

/**
 * Cargar usuarios desde archivo
 */
function loadUsers() {
    global $usersFile;
    
    if (!file_exists($usersFile)) {
        return [];
    }
    
    $content = file_get_contents($usersFile);
    $users = json_decode($content, true);
    
    return is_array($users) ? $users : [];
}

/**
 * Guardar usuarios en archivo
 */
function saveUsers($users) {
    global $usersFile;
    
    $json = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents($usersFile, $json);
}
