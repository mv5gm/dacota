<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <x-status-messages />

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Hola, {{ Auth::user()->name }}</h4>
                    <p class="card-subtitle mb-0">Has iniciado sesión correctamente en {{ config('app.name', 'Dacota') }}.</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 fs-3 text-muted">Usuario</p>
                            <h4 class="mb-0 fs-5">{{ Auth::user()->username }}</h4>
                        </div>
                        <span class="btn btn-sm bg-primary-subtle text-primary round-sm rounded-pill m-0 d-flex align-items-center">
                            <i class="ti ti-user fs-6"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 fs-3 text-muted">Correo</p>
                            <h4 class="mb-0 fs-5 text-truncate">{{ Auth::user()->email }}</h4>
                        </div>
                        <span class="btn btn-sm bg-info-subtle text-info round-sm rounded-pill m-0 d-flex align-items-center">
                            <i class="ti ti-mail fs-6"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 fs-3 text-muted">Roles asignados</p>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @forelse (Auth::user()->roleNames() as $roleName)
                                    <span class="badge bg-primary-subtle text-primary rounded-pill fs-2 py-2 px-3 text-uppercase">{{ $roleName }}</span>
                                @empty
                                    <span class="fs-3 text-muted">Sin roles</span>
                                @endforelse
                            </div>
                        </div>
                        <span class="btn btn-sm bg-warning-subtle text-warning round-sm rounded-pill m-0 d-flex align-items-center">
                            <i class="ti ti-shield fs-6"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 fs-3 text-muted">Administrador</p>
                            <h4 class="mb-0 fs-5">{{ Auth::user()->hasRole('admin') ? 'Sí' : 'No' }}</h4>
                        </div>
                        <span class="btn btn-sm bg-success-subtle text-success round-sm rounded-pill m-0 d-flex align-items-center">
                            <i class="ti ti-key fs-6"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Accesos rápidos</h4>
                    <p class="card-subtitle">Atajos a las secciones disponibles para tu rol.</p>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="ti ti-user-cog me-1"></i> Mi perfil
                        </a>

                        @role('admin|editor')
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-users me-1"></i> Gestionar usuarios
                            </a>
                            <a href="{{ route('admin.condominios.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-building-community me-1"></i> Gestionar condominios
                            </a>
                            <a href="{{ route('admin.tipo-condominios.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-tag me-1"></i> Tipos de condominio
                            </a>
                        @endrole

                        @role('admin')
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-shield-lock me-1"></i> Gestionar roles
                            </a>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-key me-1"></i> Gestionar permisos
                            </a>
                        @endrole

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-logout me-1"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-body p-2">
                    <img class="card-img-top w-100 profile-bg-height rounded overflow-hidden"
                        src="{{ asset('assets/images/backgrounds/profile-bg.jpg') }}" height="111" alt="Portada">
                    <div class="card-body little-profile text-center p-9">
                        <div class="pro-img">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="user" class="rounded-circle shadow-sm" width="112">
                        </div>
                        <h3 class="mb-1">{{ Auth::user()->name }}</h3>
                        <p class="fs-3">{{ Auth::user()->email }}</p>

                        <div class="row gx-lg-4 text-center pt-9 justify-content-center border-top">
                            <div class="col-4">
                                <h3 class="mb-0 fs-7">{{ Auth::user()->roles->count() }}</h3>
                                <small class="text-muted fs-3">Roles</small>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 fs-7">{{ Auth::user()->getAllPermissions()->count() }}</h3>
                                <small class="text-muted fs-3">Permisos</small>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 fs-7">{{ Auth::user()->email_verified_at ? 'Sí' : 'No' }}</h3>
                                <small class="text-muted fs-3">Verificado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
