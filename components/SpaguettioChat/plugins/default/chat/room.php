<div class="spaguettio-chat-container">
    <div class="spaguettio-chat-header">
        <h2><?php echo ossn_print('spaguettio:chat:room:name'); ?></h2>
    </div>
    
    <div class="spaguettio-chat-main">
        <!-- Chat messages area -->
        <div class="spaguettio-chat-messages-wrapper">
            <div id="spaguettio-chat-messages" class="spaguettio-chat-messages">
                <div class="spaguettio-chat-welcome">
                    <p><?php echo ossn_print('spaguettio:chat:no:messages'); ?></p>
                </div>
            </div>
            
            <!-- Message input area -->
            <div class="spaguettio-chat-input-wrapper">
                <form id="spaguettio-chat-form" class="spaguettio-chat-form">
                    <input type="text" 
                           id="spaguettio-chat-input" 
                           class="spaguettio-chat-input" 
                           placeholder="<?php echo ossn_print('spaguettio:chat:type:message'); ?>" 
                           autocomplete="off"
                           maxlength="500">
                    <button type="submit" class="spaguettio-chat-send-btn">
                        <i class="fa fa-paper-plane"></i>
                        <?php echo ossn_print('spaguettio:chat:send'); ?>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Online users sidebar -->
        <div class="spaguettio-chat-users-sidebar">
            <div class="spaguettio-chat-users-header">
                <h3><?php echo ossn_print('spaguettio:chat:online:users'); ?></h3>
                <span id="spaguettio-chat-users-count" class="users-count">0</span>
            </div>
            <div id="spaguettio-chat-users-list" class="spaguettio-chat-users-list">
                <!-- Users will be dynamically loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
// Initialize chat when document is ready
document.addEventListener('DOMContentLoaded', function() {
    if (typeof SpaguettioChat !== 'undefined') {
        SpaguettioChat.init();
    }
});
</script>
