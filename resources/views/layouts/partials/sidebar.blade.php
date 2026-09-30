<aside class="left-sidebar">
    <div>
        <div class="user-profile position-relative" style="background: url('{{ asset('assets/images/backgrounds/user-info.jpg') }}') no-repeat;">
            <div class="profile-img">
                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="user" class="w-100 rounded-circle overflow-hidden">
            </div>

            <div class="close-btn cursor-pointer d-flex align-items-center justify-content-center d-xl-none end-0 p-2 position-absolute sidebartoggler text-white top-0" id="sidebarCollapse">
                <i class="ti ti-x fs-7"></i>
            </div>

            <div class="profile-text hide-menu pt-1 dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex gap-2">
                        <i class="ti ti-user feather-sm text-info"></i>
                        Mi perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex gap-2 w-100 border-0 bg-transparent">
                            <i class="ti ti-logout feather-sm text-danger"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-menu-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Panel</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                @role('admin|editor')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Usuarios</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.condominios.*') ? 'active' : '' }}" href="{{ route('admin.condominios.index') }}" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-building-community"></i>
                            </span>
                            <span class="hide-menu">Condominios</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.tipo-condominios.*') ? 'active' : '' }}" href="{{ route('admin.tipo-condominios.index') }}" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-tag"></i>
                            </span>
                            <span class="hide-menu">Tipos de condominio</span>
                        </a>
                    </li>
                @endrole

                @role('admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-shield-lock"></i>
                            </span>
                            <span class="hide-menu">Roles</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-key"></i>
                            </span>
                            <span class="hide-menu">Permisos</span>
                        </a>
                    </li>
                @endrole

                <li class="nav-small-cap">
                    <i class="ti ti-menu-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Cuenta</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-user-cog"></i>
                        </span>
                        <span class="hide-menu">Mi perfil</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
