<?php
session_start();

// Configuración de admin - CAMBIAR ESTAS CREDENCIALES
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'spaguettio2026'); // ¡CAMBIAR EN PRODUCCIÓN!

// Procesar login/logout
if (isset($_POST['login'])) {
    if ($_POST['username'] === ADMIN_USERNAME && $_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['chat_admin'] = true;
    } else {
        $error = 'Credenciales incorrectas';
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['chat_admin']);
    header('Location: chat-admin.php');
    exit;
}

// Verificar autenticación
$isAdmin = isset($_SESSION['chat_admin']) && $_SESSION['chat_admin'] === true;

// Procesar acciones de administración
if ($isAdmin && isset($_POST['action'])) {
    $messagesFile = __DIR__ . '/chat_messages.json';
    $usersFile = __DIR__ . '/chat_users.json';
    
    switch ($_POST['action']) {
        case 'clear_messages':
            file_put_contents($messagesFile, json_encode([]));
            $success = 'Todos los mensajes han sido eliminados';
            break;
            
        case 'clear_users':
            file_put_contents($usersFile, json_encode([]));
            $success = 'Lista de usuarios limpiada';
            break;
            
        case 'delete_message':
            $messageId = intval($_POST['message_id']);
            $messages = json_decode(file_get_contents($messagesFile), true) ?: [];
            $messages = array_filter($messages, function($msg) use ($messageId) {
                return $msg['id'] !== $messageId;
            });
            file_put_contents($messagesFile, json_encode(array_values($messages), JSON_PRETTY_PRINT));
            $success = 'Mensaje eliminado';
            break;
            
        case 'kick_user':
            $sessionId = $_POST['session_id'];
            $users = json_decode(file_get_contents($usersFile), true) ?: [];
            unset($users[$sessionId]);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
            $success = 'Usuario desconectado';
            break;
    }
}

// Cargar datos
function loadChatData() {
    $messagesFile = __DIR__ . '/chat_messages.json';
    $usersFile = __DIR__ . '/chat_users.json';
    
    $messages = [];
    $users = [];
    
    if (file_exists($messagesFile)) {
        $messages = json_decode(file_get_contents($messagesFile), true) ?: [];
    }
    
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true) ?: [];
    }
    
    return ['messages' => $messages, 'users' => $users];
}

if ($isAdmin) {
    $data = loadChatData();
    $messages = $data['messages'];
    $users = $data['users'];
    $totalMessages = count($messages);
    $totalUsers = count($users);
    
    // Calcular estadísticas
    $userMessages = [];
    foreach ($messages as $msg) {
        if ($msg['type'] === 'user') {
            if (!isset($userMessages[$msg['username']])) {
                $userMessages[$msg['username']] = 0;
            }
            $userMessages[$msg['username']]++;
        }
    }
    arsort($userMessages);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Spaguettio Chat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .login-box {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        
        .login-box h1 {
            color: #764ba2;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .login-box input:focus {
            outline: none;
            border-color: #764ba2;
        }
        
        .login-box button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .login-box button:hover {
            transform: translateY(-2px);
        }
        
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .admin-header {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            color: #764ba2;
            font-size: 28px;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .stat-card .value {
            font-size: 36px;
            font-weight: bold;
            color: #764ba2;
        }
        
        .actions-panel {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .actions-panel h2 {
            color: #764ba2;
            margin-bottom: 20px;
        }
        
        .action-btn {
            padding: 10px 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .action-btn.danger {
            background: #dc3545;
            color: white;
        }
        
        .action-btn.danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .action-btn.warning {
            background: #ffc107;
            color: #000;
        }
        
        .action-btn.warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }
        
        .data-panel {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .data-panel h2 {
            color: #764ba2;
            margin-bottom: 20px;
        }
        
        .message-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: start;
        }
        
        .message-content {
            flex: 1;
        }
        
        .message-header {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .message-username {
            font-weight: bold;
        }
        
        .message-time {
            color: #888;
        }
        
        .message-text {
            color: #333;
        }
        
        .message-item.system {
            background: #fff9c4;
        }
        
        .user-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .user-session {
            font-size: 11px;
            color: #888;
        }
        
        .user-activity {
            font-size: 12px;
            color: #666;
        }
        
        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .delete-btn:hover {
            background: #c82333;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .top-users {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .top-users h2 {
            color: #764ba2;
            margin-bottom: 20px;
        }
        
        .top-user-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .top-user-item:last-child {
            border-bottom: none;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php if (!$isAdmin): ?>
        <div class="login-box">
            <h1>🍝 Admin Panel</h1>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" name="login">Iniciar Sesión</button>
            </form>
        </div>
    <?php else: ?>
        <div class="container">
            <div class="admin-header">
                <h1>🍝 Panel de Administración - Spaguettio Chat</h1>
                <a href="?logout" class="logout-btn">Cerrar Sesión</a>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Mensajes Totales</h3>
                    <div class="value"><?php echo $totalMessages; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Usuarios Activos</h3>
                    <div class="value"><?php echo $totalUsers; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Mensajes de Sistema</h3>
                    <div class="value">
                        <?php echo count(array_filter($messages, fn($m) => $m['type'] === 'system')); ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Usuarios Únicos</h3>
                    <div class="value"><?php echo count($userMessages); ?></div>
                </div>
            </div>
            
            <div class="actions-panel">
                <h2>🛠️ Acciones de Administración</h2>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="clear_messages">
                    <button type="submit" class="action-btn danger" 
                            onclick="return confirm('¿Estás seguro de eliminar TODOS los mensajes?')">
                        🗑️ Eliminar Todos los Mensajes
                    </button>
                </form>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="clear_users">
                    <button type="submit" class="action-btn warning" 
                            onclick="return confirm('¿Estás seguro de desconectar a TODOS los usuarios?')">
                        👥 Limpiar Lista de Usuarios
                    </button>
                </form>
                <a href="chat.php" target="_blank" class="action-btn" style="background: #28a745; color: white; text-decoration: none; display: inline-block;">
                    💬 Ir al Chat
                </a>
            </div>
            
            <?php if (count($userMessages) > 0): ?>
            <div class="top-users">
                <h2>📊 Top Usuarios Más Activos</h2>
                <?php foreach (array_slice($userMessages, 0, 10) as $username => $count): ?>
                    <div class="top-user-item">
                        <span><strong><?php echo htmlspecialchars($username); ?></strong></span>
                        <span><?php echo $count; ?> mensajes</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <div class="data-panel">
                <h2>👥 Usuarios Conectados (<?php echo $totalUsers; ?>)</h2>
                <?php if (empty($users)): ?>
                    <p style="color: #888; text-align: center; padding: 20px;">No hay usuarios conectados</p>
                <?php else: ?>
                    <?php foreach ($users as $sessionId => $user): ?>
                        <div class="user-item">
                            <div class="user-info">
                                <div class="user-name" style="color: <?php echo $user['color']; ?>">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </div>
                                <div class="user-session">Sesión: <?php echo substr($sessionId, 0, 20); ?>...</div>
                                <div class="user-activity">
                                    Última actividad: <?php echo date('Y-m-d H:i:s', $user['last_activity']); ?>
                                </div>
                            </div>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="kick_user">
                                <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($sessionId); ?>">
                                <button type="submit" class="delete-btn" 
                                        onclick="return confirm('¿Desconectar a este usuario?')">
                                    ❌ Desconectar
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="data-panel">
                <h2>💬 Mensajes Recientes (<?php echo $totalMessages; ?>)</h2>
                <?php if (empty($messages)): ?>
                    <p style="color: #888; text-align: center; padding: 20px;">No hay mensajes</p>
                <?php else: ?>
                    <?php foreach (array_reverse($messages) as $msg): ?>
                        <div class="message-item <?php echo $msg['type'] === 'system' ? 'system' : ''; ?>">
                            <div class="message-content">
                                <div class="message-header">
                                    <span class="message-username" style="color: <?php echo $msg['color']; ?>">
                                        <?php echo htmlspecialchars($msg['username']); ?>
                                    </span>
                                    <span class="message-time"><?php echo $msg['time']; ?></span>
                                    <span style="color: #888;">[ID: <?php echo $msg['id']; ?>]</span>
                                </div>
                                <div class="message-text">
                                    <?php echo htmlspecialchars($msg['message']); ?>
                                </div>
                            </div>
                            <?php if ($msg['type'] !== 'system'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_message">
                                    <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
                                    <button type="submit" class="delete-btn">🗑️</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
