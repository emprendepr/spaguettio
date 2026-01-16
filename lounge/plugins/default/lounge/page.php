<?php
/**
 * Vista principal del lounge integrada con OSSN
 */
$username = $params['username'];
$userColor = $params['color'];
?>
<div class="lounge-container">
    <div class="lounge-header-info">
        <span class="current-user" style="color: <?php echo htmlspecialchars($userColor); ?>">
            <?php echo htmlspecialchars($username); ?>
        </span>
        <button onclick="cambiarNombreLounge()" class="btn btn-primary btn-sm"><?php echo ossn_print('lounge:change:name'); ?></button>
    </div>

    <div class="lounge-main-area">
        <aside class="lounge-users-sidebar">
            <h4><?php echo ossn_print('lounge:users:online'); ?></h4>
            <div id="lounge-users-list"></div>
        </aside>

        <div class="lounge-content-area">
            <div id="lounge-messages-container" class="lounge-messages-container"></div>
            
            <div class="lounge-emoticons-bar">
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('😀')">😀</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('😂')">😂</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('❤️')">❤️</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('😍')">😍</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('😎')">😎</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('🎉')">🎉</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('🔥')">🔥</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('👍')">👍</span>
                <span class="lounge-emoticon" onclick="insertEmoticonLounge('🍝')">🍝</span>
            </div>

            <div class="lounge-input-area">
                <input type="text" 
                       id="lounge-message-input" 
                       placeholder="<?php echo ossn_print('lounge:input:placeholder'); ?>" 
                       onkeypress="handleLoungeKeyPress(event)"
                       maxlength="500">
                <button onclick="enviarMensajeLounge()" class="btn btn-primary">
                    <?php echo ossn_print('lounge:button:send'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variables globales para el lounge
    const loungeUsername = <?php echo json_encode($username); ?>;
    const loungeUserColor = <?php echo json_encode($userColor); ?>;
</script>
