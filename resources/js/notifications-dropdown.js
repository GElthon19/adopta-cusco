// Script para manejar el dropdown de notificaciones con acciones
document.addEventListener('DOMContentLoaded', function() {
    const notificationIcon = document.getElementById('notification-icon');
    const notificationDropdown = document.getElementById('notifications-dropdown');
    
    if (!notificationIcon || !notificationDropdown) return;

    // Toggle dropdown al hacer click en el ícono
    notificationIcon.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        notificationDropdown.classList.toggle('show');
        
        // Cargar notificaciones si el dropdown se abre
        if (notificationDropdown.classList.contains('show')) {
            loadNotifications();
        }
    });

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
            notificationDropdown.classList.remove('show');
        }
    });

    // Función para cargar notificaciones
    function loadNotifications() {
        fetch('/notifications/dropdown')
            .then(response => response.json())
            .then(data => {
                renderNotifications(data.notifications);
                updateBadgeCount(data.unread_count);
            })
            .catch(error => console.error('Error cargando notificaciones:', error));
    }

    // Renderizar notificaciones en el dropdown
    function renderNotifications(notifications) {
        const container = document.getElementById('notifications-container');
        
        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="notification-empty">
                    <i class="bi bi-bell-slash"></i>
                    <p>No tienes notificaciones</p>
                </div>
            `;
            return;
        }

        container.innerHTML = notifications.map(notification => `
            <div class="notification-dropdown-item ${!notification.is_read ? 'unread' : ''}" data-id="${notification.id}">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <span class="badge ${notification.type === 'adopcion' ? 'bg-success' : 'bg-info'} mb-2">
                            ${notification.type === 'adopcion' ? 'Adopción' : 'Donación'}
                        </span>
                        <div class="notification-message">${notification.message}</div>
                        <div class="notification-time">
                            <i class="bi bi-clock"></i> ${notification.time_ago}
                        </div>
                    </div>
                    ${!notification.is_read ? '<span class="badge bg-danger ms-2">Nuevo</span>' : ''}
                </div>
                
                ${notification.can_action ? `
                    <div class="notification-actions">
                        <button class="btn btn-sm btn-primary view-notification" data-url="${notification.view_url}">
                            <i class="bi bi-eye"></i> Ver
                        </button>
                        ${notification.can_approve ? `
                            <button class="btn btn-sm btn-success approve-notification" data-id="${notification.related_id}" data-type="${notification.type}">
                                <i class="bi bi-check-circle"></i> Aceptar
                            </button>
                            <button class="btn btn-sm btn-danger reject-notification" data-id="${notification.related_id}" data-type="${notification.type}">
                                <i class="bi bi-x-circle"></i> Rechazar
                            </button>
                        ` : ''}
                    </div>
                ` : ''}
            </div>
        `).join('');

        // Agregar event listeners a los botones
        attachNotificationActions();
    }

    // Agregar listeners a los botones de acciones
    function attachNotificationActions() {
        // Botón Ver
        document.querySelectorAll('.view-notification').forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.dataset.url;
                window.location.href = url;
            });
        });

        // Botón Aceptar
        document.querySelectorAll('.approve-notification').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const type = this.dataset.type;
                handleApprove(id, type);
            });
        });

        // Botón Rechazar
        document.querySelectorAll('.reject-notification').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const type = this.dataset.type;
                handleReject(id, type);
            });
        });
    }

    // Manejar aprobación
    function handleApprove(id, type) {
        if (!confirm('¿Estás seguro de aprobar esta solicitud?')) return;
        
        const url = type === 'adopcion' 
            ? `/admin/adopciones/${id}/aprobar`
            : `/admin/donaciones-animales/${id}/aprobar`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ respuesta_mensaje: 'Aprobado desde notificaciones' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Solicitud aprobada exitosamente', 'success');
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error al aprobar la solicitud', 'error');
        });
    }

    // Manejar rechazo
    function handleReject(id, type) {
        const motivo = prompt('Indica el motivo del rechazo (opcional):');
        if (motivo === null) return; // Cancelado
        
        const url = type === 'adopcion' 
            ? `/admin/adopciones/${id}/rechazar`
            : `/admin/donaciones-animales/${id}/rechazar`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ respuesta_mensaje: motivo || 'Rechazado' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Solicitud rechazada', 'info');
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error al rechazar la solicitud', 'error');
        });
    }

    // Actualizar contador del badge
    function updateBadgeCount(count) {
        const badge = document.getElementById('notification-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }

    // Mostrar toast notification
    function showToast(message, type) {
        // Crear toast si no existe
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
            document.body.appendChild(toastContainer);
        }

        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
        toast.show();
        
        // Eliminar después de mostrar
        toastElement.addEventListener('hidden.bs.toast', function() {
            toastElement.remove();
        });
    }

    // Cargar notificaciones inicialmente
    loadNotifications();
    
    // Actualizar cada 30 segundos
    setInterval(loadNotifications, 30000);
});
