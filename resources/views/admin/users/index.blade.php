<x-app-layout>
    <x-slot name="header">
        Usuarios
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <x-status-messages />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Registrar usuario</h4>
                    <p class="card-subtitle mb-4">Crea una cuenta nueva y asígnale los roles que necesite.</p>

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-3">
                                <x-input-label for="create_name" value="Nombre" />
                                <x-text-input id="create_name" name="name" type="text" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <div class="col-md-3">
                                <x-input-label for="create_username" value="Usuario" />
                                <x-text-input id="create_username" name="username" type="text" :value="old('username')" required />
                                <x-input-error :messages="$errors->get('username')" />
                            </div>

                            <div class="col-md-3">
                                <x-input-label for="create_email" value="Correo" />
                                <x-text-input id="create_email" name="email" type="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" />
                            </div>

                            <div class="col-md-3">
                                <x-input-label for="create_password" value="Contraseña" />
                                <x-text-input id="create_password" name="password" type="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" />
                            </div>

                            <div class="col-md-3">
                                <x-input-label for="create_password_confirmation" value="Confirmar contraseña" />
                                <x-text-input id="create_password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
                            </div>

                            <div class="col-md-9">
                                <x-input-label value="Roles" />
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    @foreach ($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" name="roles[]" value="{{ $role->name }}" id="create_role_{{ $role->id }}">
                                            <label class="form-check-label text-dark" for="create_role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('roles')" />
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <x-primary-button class="w-100">
                                    <i class="ti ti-user-plus me-1"></i> Crear usuario
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Usuarios registrados</h4>
                    <p class="card-subtitle mb-4">Edita los datos y los roles de cada cuenta, o elimínala.</p>

                    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-8 col-lg-6">
                            <x-input-label for="search" value="Buscar" />
                            <x-text-input id="search" name="search" type="text" :value="request('search')" placeholder="Nombre, usuario o correo" />
                        </div>
                        <div class="col-md-4 col-lg-6 d-flex gap-2">
                            <x-secondary-button type="submit">
                                <i class="ti ti-search me-1"></i> Filtrar
                            </x-secondary-button>
                            @if (request('search'))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="fs-3 text-muted">Cuenta</th>
                                    <th scope="col" class="fs-3 text-muted">Usuario</th>
                                    <th scope="col" class="fs-3 text-muted">Correo</th>
                                    <th scope="col" class="fs-3 text-muted">Roles</th>
                                    <th scope="col" class="fs-3 text-muted">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="fs-3 fw-medium text-dark">{{ $user->name }}</td>
                                        <td class="fs-3 text-muted">{{ $user->username }}</td>
                                        <td class="fs-3 text-muted">{{ $user->email }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @forelse ($user->roles as $role)
                                                    <span class="badge bg-primary-subtle text-primary rounded-pill fs-2 py-2 px-3 text-uppercase">{{ $role->name }}</span>
                                                @empty
                                                    <span class="fs-3 text-muted">Sin roles</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>
                                            @if ($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                    onsubmit="return confirm('¿Eliminar a {{ $user->username }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="ti ti-trash me-1"></i> Eliminar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill fs-2 py-2 px-3">Cuenta actual</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="border-top-0 pt-0">
                                            <details>
                                                <summary class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-edit me-1"></i> Editar
                                                </summary>

                                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="row g-3 mt-1">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="col-md-3">
                                                        <x-text-input name="name" type="text" :value="$user->name" required />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-text-input name="username" type="text" :value="$user->username" required />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-text-input name="email" type="email" :value="$user->email" required />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-text-input name="password" type="password" placeholder="Nueva contraseña (opcional)" autocomplete="new-password" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-text-input name="password_confirmation" type="password" placeholder="Confirmar contraseña" autocomplete="new-password" />
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-wrap gap-3">
                                                            @foreach ($roles as $role)
                                                                <div class="form-check">
                                                                    <input class="form-check-input primary" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $user->id }}_{{ $role->id }}" @checked($user->hasRole($role->name))>
                                                                    <label class="form-check-label text-dark" for="role_{{ $user->id }}_{{ $role->id }}">{{ $role->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 d-flex align-items-start">
                                                        <x-primary-button>
                                                            <i class="ti ti-device-floppy me-1"></i> Guardar
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </details>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center fs-3 text-muted py-4">No hay usuarios que coincidan con la búsqueda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
