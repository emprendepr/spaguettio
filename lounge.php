<?php
session_start();

// Generar nombre de usuario si no existe
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Usuario' . rand(1000, 9999);
}

// Generar color aleatorio único si no existe
if (!isset($_SESSION['user_color'])) {
    $_SESSION['user_color'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

$username = $_SESSION['username'];
$userColor = $_SESSION['user_color'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍝 Spaguettio Chat</title>
    <link rel="stylesheet" href="lounge-style.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div class="header-left">
                <h1>🍝 Spaguettio Chat</h1>
            </div>
            <div class="header-right">
                <span class="current-user" style="color: <?php echo htmlspecialchars($userColor); ?>;">
                    <?php echo htmlspecialchars($username); ?>
                </span>
                <button class="btn-cambiar-nombre" onclick="cambiarNombre()">Cambiar Nombre</button>
            </div>
        </div>
        
        <div class="chat-body">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h3>Usuarios en línea</h3>
                    <span class="user-count" id="user-count">0</span>
                </div>
                <div class="users-list" id="users-list">
                    <!-- Los usuarios se cargarán aquí dinámicamente -->
                </div>
            </div>
            
            <div class="chat-main">
                <div class="messages-area" id="messages">
                    <!-- Los mensajes se cargarán aquí dinámicamente -->
                </div>
                
                <div class="input-area">
                    <div class="emoticons-bar">
                        <button class="emoticon-btn" onclick="insertEmoticon('😀')">😀</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('😂')">😂</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('❤️')">❤️</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('😍')">😍</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('😎')">😎</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('🎉')">🎉</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('🔥')">🔥</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('👍')">👍</button>
                        <button class="emoticon-btn" onclick="insertEmoticon('🍝')">🍝</button>
                    </div>
                    
                    <div class="input-controls">
                        <input 
                            type="text" 
                            id="message-input" 
                            placeholder="Escribe tu mensaje..." 
                            onkeypress="handleKeyPress(event)"
                            autocomplete="off"
                        >
                        <button class="btn-enviar" onclick="enviarMensaje()">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const username = <?php echo json_encode($username); ?>;
        const userColor = <?php echo json_encode($userColor); ?>;
    </script>
    <script src="lounge-script.js"></script>
</body>
</html>
