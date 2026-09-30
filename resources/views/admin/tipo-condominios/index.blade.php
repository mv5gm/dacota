<x-app-layout>
    <x-slot name="header">
        Tipos de condominio
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <x-status-messages />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Crear tipo de condominio</h4>
                    <p class="card-subtitle mb-4">
                        Catálogo de tipos disponibles para registrar condominios.
                        <a href="{{ route('admin.condominios.index') }}" class="text-primary">Ver condominios</a>.
                    </p>

                    <form method="POST" action="{{ route('admin.tipo-condominios.store') }}" class="row g-3 align-items-end">
                        @csrf

                        <div class="col-md-9">
                            <x-input-label for="new_nombre" value="Nombre del tipo" />
                            <x-text-input id="new_nombre" name="nombre" type="text" :value="old('nombre')" required />
                            <x-input-error :messages="$errors->get('nombre')" />
                        </div>

                        <div class="col-md-3">
                            <x-primary-button class="w-100">
                                <i class="ti ti-plus me-1"></i> Crear tipo
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Tipos registrados</h4>
                    <p class="card-subtitle mb-4">Busca por nombre, renombra el tipo o elimínalo si ya no tiene condominios asociados.</p>

                    <form method="GET" action="{{ route('admin.tipo-condominios.index') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-8 col-lg-6">
                            <x-input-label for="search" value="Buscar" />
                            <x-text-input id="search" name="search" type="text" :value="request('search')" placeholder="Nombre del tipo" />
                        </div>
                        <div class="col-md-4 col-lg-6 d-flex gap-2">
                            <x-secondary-button type="submit">
                                <i class="ti ti-search me-1"></i> Filtrar
                            </x-secondary-button>
                            @if (request('search'))
                                <a href="{{ route('admin.tipo-condominios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="fs-3 text-muted">Tipo</th>
                                    <th scope="col" class="fs-3 text-muted">Condominios</th>
                                    <th scope="col" class="fs-3 text-muted">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tipos as $tipo)
                                    <tr>
                                        <td colspan="3" class="border-top-0">
                                            <form method="POST" action="{{ route('admin.tipo-condominios.update', $tipo) }}" class="row g-3 align-items-center">
                                                @csrf
                                                @method('PUT')

                                                <div class="col-md-5">
                                                    <x-text-input name="nombre" type="text" :value="$tipo->nombre" required />
                                                </div>

                                                <div class="col-md-3">
                                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill fs-2 py-2 px-3">
                                                        {{ $tipo->condominios_count }} condominio(s)
                                                    </span>
                                                </div>

                                                <div class="col-md-4 d-flex flex-wrap gap-2">
                                                    <x-primary-button>
                                                        <i class="ti ti-device-floppy me-1"></i> Guardar
                                                    </x-primary-button>

                                                    @if ($tipo->condominios_count === 0)
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="if (confirm('¿Eliminar el tipo {{ $tipo->nombre }}?')) { document.getElementById('delete-tipo-{{ $tipo->id }}').submit() }">
                                                            <i class="ti ti-trash me-1"></i> Eliminar
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </td>
                                    </tr>

                                    @if ($tipo->condominios_count === 0)
                                        <form id="delete-tipo-{{ $tipo->id }}" method="POST" action="{{ route('admin.tipo-condominios.destroy', $tipo) }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center fs-3 text-muted py-4">No hay tipos que coincidan con la búsqueda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $tipos->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
