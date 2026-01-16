<?php
session_start();

// Generar nombre de usuario aleatorio si no existe
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Usuario' . rand(1000, 9999);
}

// Generar color único para el usuario si no existe
if (!isset($_SESSION['color'])) {
    $_SESSION['color'] = sprintf('#%06X', mt_rand(0x333333, 0xFFFFFF));
}

$username = $_SESSION['username'];
$userColor = $_SESSION['color'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍝 Spaguettio Chat</title>
    <link rel="stylesheet" href="chat-style.css">
</head>
<body>
    <div class="chat-container">
        <header class="chat-header">
            <h1>🍝 Spaguettio Chat</h1>
            <div class="user-info">
                <span class="current-user" style="color: <?php echo $userColor; ?>">
                    <?php echo htmlspecialchars($username); ?>
                </span>
                <button onclick="cambiarNombre()" class="btn-change-name">Cambiar Nombre</button>
            </div>
        </header>

        <div class="chat-main">
            <aside class="users-sidebar">
                <h3>👥 Usuarios en línea</h3>
                <div id="users-list"></div>
            </aside>

            <div class="chat-area">
                <div id="messages-container" class="messages-container"></div>
                
                <div class="emoticons-bar">
                    <span class="emoticon" onclick="insertEmoticon('😀')">😀</span>
                    <span class="emoticon" onclick="insertEmoticon('😂')">😂</span>
                    <span class="emoticon" onclick="insertEmoticon('❤️')">❤️</span>
                    <span class="emoticon" onclick="insertEmoticon('😍')">😍</span>
                    <span class="emoticon" onclick="insertEmoticon('😎')">😎</span>
                    <span class="emoticon" onclick="insertEmoticon('🎉')">🎉</span>
                    <span class="emoticon" onclick="insertEmoticon('🔥')">🔥</span>
                    <span class="emoticon" onclick="insertEmoticon('👍')">👍</span>
                    <span class="emoticon" onclick="insertEmoticon('🍝')">🍝</span>
                </div>

                <div class="input-area">
                    <input type="text" 
                           id="message-input" 
                           placeholder="Escribe tu mensaje..." 
                           onkeypress="handleKeyPress(event)"
                           maxlength="500">
                    <button onclick="enviarMensaje()" class="btn-send">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales para JavaScript
        const username = <?php echo json_encode($username); ?>;
        const userColor = <?php echo json_encode($userColor); ?>;
    </script>
    <script src="chat-script.js"></script>
</body>
</html>
