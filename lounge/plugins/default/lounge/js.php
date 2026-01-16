// Lounge JavaScript - Integrado con OSSN

// Variables globales
let loungeLastMessageId = 0;
let loungeUpdateInterval;
const LOUNGE_UPDATE_FREQUENCY = 2000; // 2 segundos

// Inicializar al cargar la página si estamos en la página del lounge
if (typeof loungeUsername !== 'undefined') {
    document.addEventListener('DOMContentLoaded', function() {
        // Enfocar el input automáticamente
        const input = document.getElementById('lounge-message-input');
        if (input) {
            input.focus();
            
            // Cargar mensajes y usuarios inicialmente
            cargarMensajesLounge();
            cargarUsuariosLounge();
            
            // Actualizar cada 2 segundos
            loungeUpdateInterval = setInterval(function() {
                cargarMensajesLounge();
                cargarUsuariosLounge();
            }, LOUNGE_UPDATE_FREQUENCY);
        }
    });
}

// Función para enviar mensaje
function enviarMensajeLounge() {
    const input = document.getElementById('lounge-message-input');
    const message = input.value.trim();
    
    if (message === '') {
        return;
    }
    
    // Enviar mensaje al servidor
    Ossn.PostRequest({
        url: Ossn.site_url + 'action/lounge/send',
        data: {
            message: message
        },
        callback: function(response) {
            if (response) {
                input.value = '';
                cargarMensajesLounge();
            }
        }
    });
}

// Función para cargar mensajes nuevos
function cargarMensajesLounge() {
    fetch(Ossn.site_url + 'action/lounge/get_messages?last_id=' + loungeLastMessageId)
    .then(response => response.json())
    .then(data => {
        if (data.success && data.messages.length > 0) {
            data.messages.forEach(message => {
                agregarMensajeLounge(message);
                if (message.id > loungeLastMessageId) {
                    loungeLastMessageId = message.id;
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Función para agregar mensaje al DOM
function agregarMensajeLounge(message) {
    const container = document.getElementById('lounge-messages-container');
    if (!container) return;
    
    // Evitar duplicados
    if (document.getElementById('lounge-msg-' + message.id)) {
        return;
    }
    
    // Verificar si el usuario está en el fondo antes de agregar
    const isAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 100;
    
    const messageDiv = document.createElement('div');
    messageDiv.id = 'lounge-msg-' + message.id;
    
    if (message.type === 'system') {
        messageDiv.className = 'lounge-message system';
        messageDiv.innerHTML = `
            <div class="lounge-message-content">
                ${escapeHtmlLounge(message.message)}
            </div>
        `;
    } else {
        const isOwn = message.username === loungeUsername;
        messageDiv.className = isOwn ? 'lounge-message own' : 'lounge-message other';
        
        messageDiv.innerHTML = `
            <div class="lounge-message-header">
                <span class="lounge-message-username" style="color: ${message.color}">
                    ${escapeHtmlLounge(message.username)}
                </span>
                <span class="lounge-message-time">${message.time}</span>
            </div>
            <div class="lounge-message-content">
                ${escapeHtmlLounge(message.message)}
            </div>
        `;
    }
    
    container.appendChild(messageDiv);
    
    // Auto-scroll solo si el usuario estaba en el fondo
    if (isAtBottom) {
        container.scrollTop = container.scrollHeight;
    }
}

// Función para cargar usuarios activos
function cargarUsuariosLounge() {
    fetch(Ossn.site_url + 'action/lounge/get_users')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const usersList = document.getElementById('lounge-users-list');
            if (!usersList) return;
            
            usersList.innerHTML = '';
            
            data.users.forEach(user => {
                const userDiv = document.createElement('div');
                userDiv.className = 'lounge-user-item';
                userDiv.onclick = function() { mencionarUsuarioLounge(user.username); };
                
                userDiv.innerHTML = `
                    <span class="status-indicator"></span>
                    <span class="username" style="color: ${user.color}">
                        ${escapeHtmlLounge(user.username)}
                    </span>
                `;
                
                usersList.appendChild(userDiv);
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Función para mencionar usuario
function mencionarUsuarioLounge(username) {
    const input = document.getElementById('lounge-message-input');
    if (input) {
        input.value = '@' + username + ' ' + input.value;
        input.focus();
    }
}

// Función para insertar emoticon
function insertEmoticonLounge(emoticon) {
    const input = document.getElementById('lounge-message-input');
    if (input) {
        input.value += emoticon;
        input.focus();
    }
}

// Función para manejar Enter
function handleLoungeKeyPress(event) {
    if (event.key === 'Enter') {
        enviarMensajeLounge();
    }
}

// Función para cambiar nombre
function cambiarNombreLounge() {
    const nuevoNombre = prompt(Ossn.Print('lounge:name:prompt'));
    
    if (nuevoNombre && nuevoNombre.trim() !== '') {
        Ossn.PostRequest({
            url: Ossn.site_url + 'action/lounge/change_name',
            data: {
                new_name: nuevoNombre.trim()
            },
            callback: function(response) {
                if (response) {
                    // Recargar la página para actualizar el nombre en el header
                    location.reload();
                }
            }
        });
    }
}

// Función para escapar HTML (prevenir XSS)
function escapeHtmlLounge(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
