<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <div class="brand-logo d-none d-xl-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="text-nowrap logo-img d-flex align-items-center gap-2">
                    <b class="logo-icon d-inline-flex">
                        <i class="ti ti-shield-check fs-4"></i>
                    </b>
                    <span class="logo-text fw-semibold fs-3 lh-sm">{{ config('app.name', 'Dacota') }}</span>
                </a>
            </div>

            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>

            <li class="nav-item d-none d-sm-block">
                <span class="nav-link fs-3 text-muted">
                    {{ request()->routeIs('dashboard') ? 'Dashboard' : (request()->routeIs('admin.users.*') ? 'Usuarios' : (request()->routeIs('admin.roles.*') ? 'Roles' : (request()->routeIs('admin.permissions.*') ? 'Permisos' : (request()->routeIs('profile.*') ? 'Mi perfil' : config('app.name', 'Dacota'))))) }}
                </span>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item me-2">
                    <span class="badge bg-light text-dark border rounded-pill fs-2 py-2 px-3">
                        <i class="ti ti-id-badge-2 me-1"></i>
                        {{ Auth::user()->username }}
                    </span>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">Mi perfil</p>
                            </a>
                            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-home fs-6"></i>
                                <p class="mb-0 fs-3">Dashboard</p>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary mx-3 mt-2 mb-2 d-block w-100">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
