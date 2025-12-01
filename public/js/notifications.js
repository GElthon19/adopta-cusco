// Actualizar el contador de notificaciones no leídas
function actualizarContadorNotificaciones() {
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notification-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error al obtener notificaciones:', error));
}

// Actualizar al cargar la página
document.addEventListener('DOMContentLoaded', actualizarContadorNotificaciones);

// Actualizar cada 30 segundos
setInterval(actualizarContadorNotificaciones, 30000);
