// Variables globales
let lastMessageId = 0;
let updateInterval;

// Esperar a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // Cargar mensajes y usuarios inicialmente
    cargarMensajes();
    cargarUsuarios();
    
    // Iniciar actualización automática cada 2 segundos
    updateInterval = setInterval(function() {
        cargarMensajes();
        cargarUsuarios();
    }, 2000);
    
    // Enfocar el input de mensaje
    document.getElementById('message-input').focus();
});

// Función para enviar mensaje
function enviarMensaje() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    
    if (message === '') {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'send');
    formData.append('message', message);
    
    fetch('lounge-api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            cargarMensajes();
        }
    })
    .catch(error => console.error('Error al enviar mensaje:', error));
}

// Función para cargar mensajes
function cargarMensajes() {
    fetch(`lounge-api.php?action=get_messages&last_id=${lastMessageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                const messagesContainer = document.getElementById('messages');
                const wasNearBottom = isNearBottom(messagesContainer);
                
                data.messages.forEach(msg => {
                    agregarMensaje(msg);
                    if (msg.id > lastMessageId) {
                        lastMessageId = msg.id;
                    }
                });
                
                // Auto-scroll solo si el usuario estaba cerca del fondo
                if (wasNearBottom) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }
        })
        .catch(error => console.error('Error al cargar mensajes:', error));
}

// Función para verificar si el usuario está cerca del fondo
function isNearBottom(element) {
    const threshold = 100;
    return element.scrollHeight - element.scrollTop - element.clientHeight < threshold;
}

// Función para agregar mensaje al DOM
function agregarMensaje(msg) {
    const messagesContainer = document.getElementById('messages');
    
    // Verificar si el mensaje ya existe (evitar duplicados)
    if (document.getElementById('msg-' + msg.id)) {
        return;
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.id = 'msg-' + msg.id;
    
    if (msg.type === 'system') {
        messageDiv.className = 'system-message';
        messageDiv.textContent = msg.message;
    } else {
        const isOwn = msg.username === username;
        messageDiv.className = isOwn ? 'message own' : 'message other';
        
        const headerDiv = document.createElement('div');
        headerDiv.className = 'message-header';
        headerDiv.style.color = isOwn ? 'rgba(255, 255, 255, 0.9)' : msg.color;
        headerDiv.textContent = msg.username;
        
        const textDiv = document.createElement('div');
        textDiv.className = 'message-text';
        textDiv.textContent = escapeHtml(msg.message);
        
        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        timeDiv.textContent = msg.time;
        
        messageDiv.appendChild(headerDiv);
        messageDiv.appendChild(textDiv);
        messageDiv.appendChild(timeDiv);
    }
    
    messagesContainer.appendChild(messageDiv);
}

// Función para cargar usuarios
function cargarUsuarios() {
    fetch('lounge-api.php?action=get_users')
        .then(response => response.json())
        .then(data => {
            if (data.users) {
                const usersList = document.getElementById('users-list');
                const userCount = document.getElementById('user-count');
                
                userCount.textContent = data.users.length;
                usersList.innerHTML = '';
                
                data.users.forEach(user => {
                    const userDiv = document.createElement('div');
                    userDiv.className = 'user-item online';
                    userDiv.style.color = user.color;
                    userDiv.textContent = user.username;
                    userDiv.onclick = function() {
                        mencionarUsuario(user.username);
                    };
                    usersList.appendChild(userDiv);
                });
            }
        })
        .catch(error => console.error('Error al cargar usuarios:', error));
}

// Función para mencionar a un usuario
function mencionarUsuario(nombreUsuario) {
    const input = document.getElementById('message-input');
    input.value = '@' + nombreUsuario + ' ' + input.value;
    input.focus();
}

// Función para insertar emoticón
function insertEmoticon(emoticon) {
    const input = document.getElementById('message-input');
    input.value += emoticon;
    input.focus();
}

// Función para manejar la tecla Enter
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        enviarMensaje();
    }
}

// Función para cambiar nombre
function cambiarNombre() {
    const nuevoNombre = prompt('Ingresa tu nuevo nombre:');
    
    if (nuevoNombre && nuevoNombre.trim() !== '') {
        const formData = new FormData();
        formData.append('action', 'change_name');
        formData.append('new_name', nuevoNombre.trim());
        
        fetch('lounge-api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error al cambiar nombre:', error));
    }
}

// Función para escapar HTML (evitar XSS)
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.textContent;
}
