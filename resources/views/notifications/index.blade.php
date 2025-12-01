@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-bell"></i> Notificaciones</h2>
                @if($notifications->where('is_read', false)->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check-all"></i> Marcar todas como leídas
                        </button>
                    </form>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    @forelse($notifications as $notification)
                        <div class="notification-item p-3 mb-2 border-bottom {{ $notification->is_read ? 'bg-light' : 'bg-white border-start border-primary border-4' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        @if($notification->type === 'adopcion')
                                            <span class="badge bg-success me-2">
                                                <i class="bi bi-heart"></i> Adopción
                                            </span>
                                        @else
                                            <span class="badge bg-info me-2">
                                                <i class="bi bi-cash-coin"></i> Donación
                                            </span>
                                        @endif
                                        
                                        @if(!$notification->is_read)
                                            <span class="badge bg-danger">Nuevo</span>
                                        @endif
                                    </div>
                                    
                                    <p class="mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">
                                        {{ $notification->message }}
                                    </p>
                                    
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> 
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                @if(!$notification->is_read)
                                    <button 
                                        class="btn btn-sm btn-outline-secondary mark-as-read-btn" 
                                        data-notification-id="{{ $notification->id }}">
                                        <i class="bi bi-check"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No tienes notificaciones</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Marcar notificación como leída
    document.querySelectorAll('.mark-as-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                }
            });
        });
    });
});
</script>
@endpush
