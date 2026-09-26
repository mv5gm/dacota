<x-app-layout>
    <x-slot name="header">
        Roles y permisos
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <x-status-messages />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Crear rol</h4>
                    <p class="card-subtitle mb-4">El nombre debe ser una sola palabra, sin espacios (ejemplo: <span class="font-monospace">auditor</span>).</p>

                    <form method="POST" action="{{ route('admin.roles.store') }}" class="row g-3 align-items-end">
                        @csrf

                        <div class="col-md-9">
                            <x-input-label for="new_role_name" value="Nombre del rol" />
                            <x-text-input id="new_role_name" name="name" type="text" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="col-md-3">
                            <x-primary-button class="w-100">
                                <i class="ti ti-plus me-1"></i> Crear rol
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @forelse ($roles as $role)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                            @csrf
                            @method('PUT')

                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <x-text-input name="name" type="text" value="{{ $role->name }}" class="w-100" required />
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill fs-2 py-2 px-3">
                                        {{ $role->users_count }} usuario(s)
                                    </span>
                                    @if ($role->name === 'admin')
                                        <span class="badge bg-success-subtle text-success rounded-pill fs-2 py-2 px-3 text-uppercase">Protegido</span>
                                    @endif
                                </div>

                                <div class="d-flex gap-2">
                                    <x-primary-button>
                                        <i class="ti ti-device-floppy me-1"></i> Guardar
                                    </x-primary-button>

                                    @if ($role->name !== 'admin')
                                        <button type="button" class="btn btn-danger" onclick="if (confirm('¿Eliminar el rol {{ $role->name }}?')) { document.getElementById('delete-role-{{ $role->id }}').submit() }">
                                            <i class="ti ti-trash me-1"></i> Eliminar
                                        </button>
                                    @endif
                                </div>
                            </div>

                            @if ($permissions->isEmpty())
                                <p class="fs-3 text-muted mb-0">Aún no hay permisos registrados.</p>
                            @else
                                <div class="row g-3">
                                    @foreach ($permissions as $group => $groupPermissions)
                                        <div class="col-md-4 col-xl-3">
                                            <div class="p-3 rounded-2 bg-light h-100">
                                                <p class="fs-3 fw-semibold text-uppercase text-muted mb-3">{{ $group }}</p>

                                                <div class="d-flex flex-column gap-2">
                                                    @foreach ($groupPermissions as $permission)
                                                        <div class="form-check">
                                                            <input class="form-check-input primary" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                                id="role_{{ $role->id }}_perm_{{ $permission->id }}" @checked($role->hasPermissionTo($permission->name))>
                                                            <label class="form-check-label font-monospace fs-3 text-dark" for="role_{{ $role->id }}_perm_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </form>

                        @if ($role->name !== 'admin')
                            <form id="delete-role-{{ $role->id }}" method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center fs-3 text-muted">No hay roles registrados.</div>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
