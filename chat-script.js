// Variables globales
let lastMessageId = 0;
let updateInterval;
const UPDATE_FREQUENCY = 2000; // 2 segundos

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Enfocar el input automáticamente
    document.getElementById('message-input').focus();
    
    // Cargar mensajes y usuarios inicialmente
    cargarMensajes();
    cargarUsuarios();
    
    // Actualizar cada 2 segundos
    updateInterval = setInterval(function() {
        cargarMensajes();
        cargarUsuarios();
    }, UPDATE_FREQUENCY);
});

// Función para enviar mensaje
function enviarMensaje() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    
    if (message === '') {
        return;
    }
    
    // Enviar mensaje al servidor
    fetch('chat-api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=send&message=' + encodeURIComponent(message)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            cargarMensajes();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Función para cargar mensajes nuevos
function cargarMensajes() {
    fetch('chat-api.php?action=get_messages&last_id=' + lastMessageId)
    .then(response => response.json())
    .then(data => {
        if (data.success && data.messages.length > 0) {
            data.messages.forEach(message => {
                agregarMensaje(message);
                if (message.id > lastMessageId) {
                    lastMessageId = message.id;
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Función para agregar mensaje al DOM
function agregarMensaje(message) {
    const container = document.getElementById('messages-container');
    
    // Evitar duplicados
    if (document.getElementById('msg-' + message.id)) {
        return;
    }
    
    // Verificar si el usuario está en el fondo antes de agregar
    const isAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 100;
    
    const messageDiv = document.createElement('div');
    messageDiv.id = 'msg-' + message.id;
    
    if (message.type === 'system') {
        messageDiv.className = 'message system';
        messageDiv.innerHTML = `
            <div class="message-content">
                ${escapeHtml(message.message)}
            </div>
        `;
    } else {
        const isOwn = message.username === username;
        messageDiv.className = isOwn ? 'message own' : 'message other';
        
        messageDiv.innerHTML = `
            <div class="message-header">
                <span class="message-username" style="color: ${message.color}">
                    ${escapeHtml(message.username)}
                </span>
                <span class="message-time">${message.time}</span>
            </div>
            <div class="message-content">
                ${escapeHtml(message.message)}
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
function cargarUsuarios() {
    fetch('chat-api.php?action=get_users')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const usersList = document.getElementById('users-list');
            usersList.innerHTML = '';
            
            data.users.forEach(user => {
                const userDiv = document.createElement('div');
                userDiv.className = 'user-item';
                userDiv.onclick = function() { mencionarUsuario(user.username); };
                
                userDiv.innerHTML = `
                    <span class="status-indicator"></span>
                    <span class="username" style="color: ${user.color}">
                        ${escapeHtml(user.username)}
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
function mencionarUsuario(username) {
    const input = document.getElementById('message-input');
    input.value = '@' + username + ' ' + input.value;
    input.focus();
}

// Función para insertar emoticon
function insertEmoticon(emoticon) {
    const input = document.getElementById('message-input');
    input.value += emoticon;
    input.focus();
}

// Función para manejar Enter
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        enviarMensaje();
    }
}

// Función para cambiar nombre
function cambiarNombre() {
    const nuevoNombre = prompt('Ingresa tu nuevo nombre:');
    
    if (nuevoNombre && nuevoNombre.trim() !== '') {
        fetch('chat-api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=change_name&new_name=' + encodeURIComponent(nuevoNombre.trim())
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recargar la página para actualizar el nombre en el header
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Función para escapar HTML (prevenir XSS)
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
