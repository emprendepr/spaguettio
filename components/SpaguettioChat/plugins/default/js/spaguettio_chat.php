<?php
/**
 * Spaguettio Chat JavaScript
 * Real-time chat functionality
 */
?>
var SpaguettioChat = {
    currentUser: null,
    currentRoom: 'main',
    lastMessageId: 0,
    updateInterval: null,
    
    init: function() {
        this.getCurrentUser();
        this.registerUserInChat();
        this.loadMessages();
        this.loadUsers();
        this.setupEventListeners();
        this.startAutoUpdate();
    },
    
    getCurrentUser: function() {
        // Get current user info from OSSN
        if (typeof ossn !== 'undefined' && ossn.loggedin_user) {
            this.currentUser = ossn.loggedin_user;
        }
    },
    
    registerUserInChat: function() {
        // Register user entry in chat
        Ossn.PostRequest({
            url: ossn_site_url + 'action/chat/register_user',
            data: {
                room: this.currentRoom
            },
            callback: function(response) {
                if (response) {
                    console.log('User registered in chat');
                }
            }
        });
    },
    
    setupEventListeners: function() {
        var self = this;
        var form = document.getElementById('spaguettio-chat-form');
        var input = document.getElementById('spaguettio-chat-input');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                self.sendMessage();
            });
        }
        
        // Handle page unload to mark user as offline
        window.addEventListener('beforeunload', function() {
            self.unregisterUser();
        });
    },
    
    sendMessage: function() {
        var input = document.getElementById('spaguettio-chat-input');
        var message = input.value.trim();
        
        if (!message) return;
        
        var self = this;
        Ossn.PostRequest({
            url: ossn_site_url + 'action/chat/send',
            data: {
                message: message,
                room: this.currentRoom
            },
            callback: function(response) {
                if (response && response.success) {
                    input.value = '';
                    self.loadMessages();
                } else {
                    alert('Error sending message');
                }
            }
        });
    },
    
    loadMessages: function() {
        var self = this;
        Ossn.PostRequest({
            url: ossn_site_url + 'action/chat/get_messages',
            data: {
                room: this.currentRoom,
                last_id: this.lastMessageId
            },
            callback: function(response) {
                if (response && response.messages) {
                    self.displayMessages(response.messages);
                }
            }
        });
    },
    
    displayMessages: function(messages) {
        if (!messages || messages.length === 0) return;
        
        var container = document.getElementById('spaguettio-chat-messages');
        var welcome = container.querySelector('.spaguettio-chat-welcome');
        
        if (welcome) {
            welcome.remove();
        }
        
        messages.forEach(function(msg) {
            if (msg.id > this.lastMessageId) {
                this.lastMessageId = msg.id;
                var messageEl = this.createMessageElement(msg);
                container.appendChild(messageEl);
            }
        }.bind(this));
        
        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    },
    
    createMessageElement: function(msg) {
        var div = document.createElement('div');
        div.className = 'spaguettio-chat-message';
        
        if (msg.type === 'system') {
            div.innerHTML = '<div class="chat-message-system">' + msg.message + '</div>';
        } else {
            var time = new Date(msg.time_created * 1000).toLocaleTimeString();
            div.innerHTML = 
                '<div class="chat-message-bubble">' +
                    '<div class="chat-message-header">' +
                        '<img src="' + msg.user_avatar + '" class="chat-message-avatar" alt="' + msg.username + '">' +
                        '<span class="chat-message-username">' + msg.username + '</span>' +
                        '<span class="chat-message-time">' + time + '</span>' +
                    '</div>' +
                    '<div class="chat-message-text">' + this.escapeHtml(msg.message) + '</div>' +
                '</div>';
        }
        
        return div;
    },
    
    loadUsers: function() {
        var self = this;
        Ossn.PostRequest({
            url: ossn_site_url + 'action/chat/get_users',
            data: {
                room: this.currentRoom
            },
            callback: function(response) {
                if (response && response.users) {
                    self.displayUsers(response.users);
                }
            }
        });
    },
    
    displayUsers: function(users) {
        var container = document.getElementById('spaguettio-chat-users-list');
        var countEl = document.getElementById('spaguettio-chat-users-count');
        
        container.innerHTML = '';
        countEl.textContent = users.length;
        
        users.forEach(function(user) {
            var userEl = document.createElement('div');
            userEl.className = 'chat-user-item';
            userEl.innerHTML = 
                '<img src="' + user.avatar + '" class="chat-user-avatar" alt="' + user.username + '">' +
                '<div class="chat-user-info">' +
                    '<div class="chat-user-name">' + user.username + '<span class="chat-user-status"></span></div>' +
                '</div>';
            container.appendChild(userEl);
        });
    },
    
    startAutoUpdate: function() {
        var self = this;
        this.updateInterval = setInterval(function() {
            self.loadMessages();
            self.loadUsers();
        }, 3000); // Update every 3 seconds
    },
    
    unregisterUser: function() {
        // Mark user as offline
        navigator.sendBeacon(
            ossn_site_url + 'action/chat/unregister_user',
            new URLSearchParams({ room: this.currentRoom })
        );
    },
    
    escapeHtml: function(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    },
    
    // Admin functions
    Admin: {
        init: function() {
            this.loadStatistics();
            this.loadRooms();
            this.setupAdminListeners();
        },
        
        setupAdminListeners: function() {
            var settingsForm = document.getElementById('chat-settings-form');
            if (settingsForm) {
                settingsForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    SpaguettioChat.Admin.saveSettings();
                });
            }
            
            var newRoomForm = document.getElementById('new-room-form');
            if (newRoomForm) {
                newRoomForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    SpaguettioChat.Admin.submitNewRoom();
                });
            }
        },
        
        showCreateRoomForm: function() {
            document.getElementById('create-room-form').style.display = 'block';
        },
        
        hideCreateRoomForm: function() {
            document.getElementById('create-room-form').style.display = 'none';
            document.getElementById('new-room-form').reset();
        },
        
        submitNewRoom: function() {
            var form = document.getElementById('new-room-form');
            var formData = new FormData(form);
            var data = {
                name: formData.get('room_name'),
                description: formData.get('description'),
                max_users: formData.get('max_users')
            };
            
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/create_room',
                data: data,
                callback: function(response) {
                    if (response && response.success) {
                        alert('Sala creada exitosamente');
                        SpaguettioChat.Admin.hideCreateRoomForm();
                        SpaguettioChat.Admin.loadRooms();
                    } else {
                        alert('Error al crear la sala: ' + (response.error || 'Error desconocido'));
                    }
                }
            });
        },
        
        loadStatistics: function() {
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/get_statistics',
                callback: function(response) {
                    if (response) {
                        document.getElementById('total-users').textContent = response.online_users || 0;
                        document.getElementById('total-messages').textContent = response.messages_today || 0;
                        document.getElementById('avg-users').textContent = response.avg_users || 0;
                    }
                }
            });
        },
        
        loadRooms: function() {
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/get_rooms',
                callback: function(response) {
                    if (response && response.rooms) {
                        SpaguettioChat.Admin.displayRooms(response.rooms);
                    }
                }
            });
        },
        
        displayRooms: function(rooms) {
            var container = document.getElementById('rooms-list');
            container.innerHTML = '';
            
            if (rooms.length === 0) {
                container.innerHTML = '<p>No hay salas disponibles.</p>';
                return;
            }
            
            rooms.forEach(function(room) {
                var roomEl = document.createElement('div');
                roomEl.className = 'room-item';
                roomEl.innerHTML = 
                    '<div class="room-info">' +
                        '<h4>' + room.name + '</h4>' +
                        '<p>' + (room.description || '') + '</p>' +
                        '<p>Usuarios: ' + room.user_count + ' / ' + room.max_users + '</p>' +
                    '</div>' +
                    '<div class="room-actions">' +
                        (room.id != 1 ? 
                            '<button class="btn btn-warning" onclick="SpaguettioChat.Admin.editRoom(' + room.id + ')">Editar</button>' +
                            '<button class="btn btn-danger" onclick="SpaguettioChat.Admin.deleteRoom(' + room.id + ')">Eliminar</button>'
                            : '<small>Sala principal (no se puede eliminar)</small>') +
                    '</div>';
                container.appendChild(roomEl);
            });
        },
        
        createRoom: function() {
            this.showCreateRoomForm();
        },
        
        editRoom: function(roomId) {
            var name = prompt('Nuevo nombre de la sala:');
            if (!name) return;
            
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/edit_room',
                data: {
                    room_id: roomId,
                    name: name
                },
                callback: function(response) {
                    if (response && response.success) {
                        alert('Sala actualizada exitosamente');
                        SpaguettioChat.Admin.loadRooms();
                    } else {
                        alert('Error al actualizar la sala');
                    }
                }
            });
        },
        
        deleteRoom: function(roomId) {
            if (!confirm('¿Está seguro de eliminar esta sala?')) return;
            
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/delete_room',
                data: {
                    room_id: roomId
                },
                callback: function(response) {
                    if (response && response.success) {
                        alert('Sala eliminada exitosamente');
                        SpaguettioChat.Admin.loadRooms();
                    } else {
                        alert('Error al eliminar la sala');
                    }
                }
            });
        },
        
        clearHistory: function() {
            if (!confirm('¿Está seguro de limpiar todo el historial del chat?')) return;
            
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/clear_history',
                callback: function(response) {
                    if (response && response.success) {
                        alert('Historial limpiado exitosamente');
                    } else {
                        alert('Error al limpiar el historial');
                    }
                }
            });
        },
        
        saveSettings: function() {
            var form = document.getElementById('chat-settings-form');
            var formData = new FormData(form);
            var data = {};
            
            formData.forEach(function(value, key) {
                data[key] = value;
            });
            
            Ossn.PostRequest({
                url: ossn_site_url + 'action/chat/save_settings',
                data: data,
                callback: function(response) {
                    if (response && response.success) {
                        alert('Configuración guardada exitosamente');
                    } else {
                        alert('Error al guardar la configuración');
                    }
                }
            });
        },
        
        viewBannedUsers: function() {
            alert('Función de usuarios bloqueados - En desarrollo');
        }
    }
};
