@extends('layouts.app')

@section('title', 'Gestión de Contenido')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-file-text"></i> Gestión de Contenido</h2>
                <a href="{{ route('content-blocks.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo Bloque
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Clave</th>
                                    <th>Etiqueta</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Última actualización</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blocks as $block)
                                    <tr>
                                        <td>{{ $block->id }}</td>
                                        <td><code>{{ $block->key }}</code></td>
                                        <td>{{ $block->label }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $block->type }}</span>
                                        </td>
                                        <td>
                                            @if($block->is_active)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>{{ $block->updated_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('content-blocks.edit', $block) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('content-blocks.destroy', $block) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este bloque?')"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger" 
                                                            title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted">No hay bloques de contenido creados</p>
                                            <a href="{{ route('content-blocks.create') }}" class="btn btn-sm btn-primary">
                                                Crear el primero
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                {{ $blocks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
