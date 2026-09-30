<x-app-layout>
    <x-slot name="header">
        Condominios
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <x-status-messages />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Registrar condominio</h4>
                    <p class="card-subtitle mb-4">
                        Crea un condominio y asígnale su tipo. El propietario se registra con tu usuario.
                        <a href="{{ route('admin.tipo-condominios.index') }}" class="text-primary">Administrar tipos de condominio</a>.
                    </p>

                    @if ($tipos->isEmpty())
                        <p class="fs-3 text-muted mb-0">
                            Primero debes registrar al menos un
                            <a href="{{ route('admin.tipo-condominios.index') }}" class="text-primary">tipo de condominio</a>.
                        </p>
                    @else
                        <form method="POST" action="{{ route('admin.condominios.store') }}" class="row g-3 align-items-end">
                            @csrf

                            <div class="col-md-6">
                                <x-input-label for="create_nombre" value="Nombre" />
                                <x-text-input id="create_nombre" name="nombre" type="text" :value="old('nombre')" required />
                                <x-input-error :messages="$errors->get('nombre')" />
                            </div>

                            <div class="col-md-3">
                                <x-input-label for="create_tipo_condominio_id" value="Tipo de condominio" />
                                <x-select-input id="create_tipo_condominio_id" name="tipo_condominio_id" required>
                                    <option value="">Selecciona un tipo</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" @selected(old('tipo_condominio_id') == $tipo->id)>{{ $tipo->nombre }}</option>
                                    @endforeach
                                </x-select-input>
                                <x-input-error :messages="$errors->get('tipo_condominio_id')" />
                            </div>

                            <div class="col-md-3">
                                <x-primary-button class="w-100">
                                    <i class="ti ti-building-community me-1"></i> Crear condominio
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Condominios registrados</h4>
                    <p class="card-subtitle mb-4">Busqua por nombre o tipo, edita los datos o elimina el condominio.</p>

                    <form method="GET" action="{{ route('admin.condominios.index') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-4">
                            <x-input-label for="search" value="Buscar" />
                            <x-text-input id="search" name="search" type="text" :value="request('search')" placeholder="Nombre o tipo de condominio" />
                        </div>

                        <div class="col-md-4">
                            <x-input-label for="filtro_tipo_condominio_id" value="Filtrar por tipo" />
                            <x-select-input id="filtro_tipo_condominio_id" name="tipo_condominio_id">
                                <option value="">Todos los tipos</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" @selected((int) request('tipo_condominio_id') === $tipo->id)>{{ $tipo->nombre }}</option>
                                @endforeach
                            </x-select-input>
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <x-secondary-button type="submit">
                                <i class="ti ti-search me-1"></i> Filtrar
                            </x-secondary-button>
                            @if (request('search') || request('tipo_condominio_id'))
                                <a href="{{ route('admin.condominios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="fs-3 text-muted">Condominio</th>
                                    <th scope="col" class="fs-3 text-muted">Tipo</th>
                                    <th scope="col" class="fs-3 text-muted">Registrado por</th>
                                    <th scope="col" class="fs-3 text-muted">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($condominios as $condominio)
                                    <tr>
                                        <td class="fs-3 fw-medium text-dark">{{ $condominio->nombre }}</td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill fs-2 py-2 px-3">
                                                {{ $condominio->tipoCondominio->nombre }}
                                            </span>
                                        </td>
                                        <td class="fs-3 text-muted">{{ $condominio->user->name }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.condominios.destroy', $condominio) }}"
                                                onsubmit="return confirm('¿Eliminar {{ $condominio->nombre }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash me-1"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-top-0 pt-0">
                                            <details>
                                                <summary class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-edit me-1"></i> Editar
                                                </summary>

                                                <form method="POST" action="{{ route('admin.condominios.update', $condominio) }}" class="row g-3 mt-1">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="col-md-6">
                                                        <x-text-input name="nombre" type="text" :value="$condominio->nombre" required />
                                                    </div>

                                                    <div class="col-md-3">
                                                        <x-select-input name="tipo_condominio_id" required>
                                                            @foreach ($tipos as $tipo)
                                                                <option value="{{ $tipo->id }}" @selected($condominio->tipo_condominio_id === $tipo->id)>{{ $tipo->nombre }}</option>
                                                            @endforeach
                                                        </x-select-input>
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
                                        <td colspan="4" class="text-center fs-3 text-muted py-4">No hay condominios que coincidan con la búsqueda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $condominios->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
