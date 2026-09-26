<x-app-layout>
    <x-slot name="header">
        Permisos
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <x-status-messages />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Crear permiso</h4>
                    <p class="card-subtitle mb-4">Usa el formato <span class="font-monospace">modulo.accion</span>, por ejemplo <span class="font-monospace">reportes.ver</span>.</p>

                    <form method="POST" action="{{ route('admin.permissions.store') }}" class="row g-3 align-items-end">
                        @csrf

                        <div class="col-md-9">
                            <x-input-label for="permission_name" value="Nombre del permiso" />
                            <x-text-input id="permission_name" name="name" type="text" :value="old('name')" placeholder="modulo.accion" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="col-md-3">
                            <x-primary-button class="w-100">
                                <i class="ti ti-plus me-1"></i> Crear permiso
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Permisos registrados</h4>
                    <p class="card-subtitle mb-4">Cada permiso aparece en la sección de su módulo dentro de la vista de roles.</p>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="fs-3 text-muted">Permiso</th>
                                    <th scope="col" class="fs-3 text-muted">Roles con acceso</th>
                                    <th scope="col" class="fs-3 text-muted">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td>
                                            <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="d-flex align-items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <x-text-input name="name" type="text" value="{{ $permission->name }}" class="font-monospace fs-3" required />
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-device-floppy"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @forelse ($permission->roles as $role)
                                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill fs-2 py-2 px-3">{{ $role->name }}</span>
                                                @empty
                                                    <span class="fs-3 text-muted">Sin roles</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}"
                                                onsubmit="return confirm('¿Eliminar el permiso {{ $permission->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash me-1"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center fs-3 text-muted py-4">No hay permisos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
