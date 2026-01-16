<div class="spaguettio-chat-admin-container">
    <div class="spaguettio-chat-admin-header">
        <h1><?php echo ossn_print('spaguettio:chat:admin:title'); ?></h1>
    </div>
    
    <div class="spaguettio-chat-admin-layout">
        <!-- Main Content Area -->
        <div class="spaguettio-chat-admin-main">
            <!-- Statistics Section -->
            <div class="admin-section">
                <h2><?php echo ossn_print('spaguettio:chat:admin:statistics'); ?></h2>
                <div class="admin-stats">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fa fa-users"></i></div>
                        <div class="stat-info">
                            <h3 id="total-users">0</h3>
                            <p>Total de Usuarios en Línea</p>
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fa fa-comments"></i></div>
                        <div class="stat-info">
                            <h3 id="total-messages">0</h3>
                            <p>Mensajes Hoy</p>
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fa fa-clock-o"></i></div>
                        <div class="stat-info">
                            <h3 id="avg-users">0</h3>
                            <p>Promedio de Usuarios</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Settings Section -->
            <div class="admin-section">
                <h2><?php echo ossn_print('spaguettio:chat:admin:settings'); ?></h2>
                <div class="admin-settings">
                    <form id="chat-settings-form" class="ossn-form">
                        <div class="form-group">
                            <label>Nombre de la Sala:</label>
                            <input type="text" name="room_name" value="Sala Principal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Máximo de Usuarios:</label>
                            <input type="number" name="max_users" value="100" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Límite de Mensajes por Minuto:</label>
                            <input type="number" name="rate_limit" value="10" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="enable_moderation" checked>
                                Activar Moderación Automática
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                    </form>
                </div>
            </div>
            
            <!-- Moderation Section -->
            <div class="admin-section">
                <h2><?php echo ossn_print('spaguettio:chat:admin:moderation'); ?></h2>
                <div class="admin-moderation">
                    <div class="moderation-actions">
                        <button class="btn btn-warning" onclick="SpaguettioChat.Admin.clearHistory()">
                            <i class="fa fa-trash"></i>
                            <?php echo ossn_print('spaguettio:chat:admin:clear:history'); ?>
                        </button>
                        <button class="btn btn-info" onclick="SpaguettioChat.Admin.viewBannedUsers()">
                            <i class="fa fa-ban"></i>
                            <?php echo ossn_print('spaguettio:chat:admin:banned:users'); ?>
                        </button>
                    </div>
                    
                    <div id="recent-activity" class="recent-activity">
                        <h3>Actividad Reciente</h3>
                        <div id="activity-list" class="activity-list">
                            <p>Cargando actividad...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar for Room Management -->
        <div class="spaguettio-chat-admin-sidebar">
            <div class="admin-sidebar-section">
                <h2><?php echo ossn_print('spaguettio:chat:admin:manage:rooms'); ?></h2>
                
                <!-- Create Room Panel -->
                <div class="create-room-panel">
                    <button class="btn btn-success btn-block" onclick="SpaguettioChat.Admin.showCreateRoomForm()">
                        <i class="fa fa-plus"></i>
                        Crear Nueva Sala
                    </button>
                    
                    <div id="create-room-form" class="create-room-form" style="display: none;">
                        <h3>Nueva Sala de Chat</h3>
                        <form id="new-room-form">
                            <div class="form-group">
                                <label>Nombre de la Sala:</label>
                                <input type="text" name="room_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción:</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Máximo de Usuarios:</label>
                                <input type="number" name="max_users" value="100" class="form-control" min="1">
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Crear Sala</button>
                                <button type="button" class="btn btn-secondary" onclick="SpaguettioChat.Admin.hideCreateRoomForm()">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Rooms List -->
                <div id="rooms-list" class="rooms-list">
                    <p>Cargando salas...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize admin panel when document is ready
document.addEventListener('DOMContentLoaded', function() {
    if (typeof SpaguettioChat !== 'undefined' && SpaguettioChat.Admin) {
        SpaguettioChat.Admin.init();
    }
});
</script>
