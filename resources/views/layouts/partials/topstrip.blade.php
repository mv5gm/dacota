<div class="app-topstrip bg-dark py-3 px-4 w-100 d-lg-flex align-items-center justify-content-between">
    <div class="d-none d-sm-flex align-items-center justify-content-center gap-9 mb-3 mb-lg-0">
        <a href="{{ route('home') }}" class="text-white d-flex align-items-center gap-2">
            <i class="ti ti-shield-check fs-5"></i>
            <span class="fs-3 fw-semibold">{{ config('app.name', 'Dacota') }}</span>
        </a>

        <div class="d-none d-xl-flex align-items-center gap-3 border-start border-white border-opacity-25 ps-9">
            <span class="text-white-50 fs-3">Control de acceso y roles</span>
        </div>
    </div>

    <div class="d-lg-flex align-items-center gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2">
            @forelse (auth()->user()->roleNames() as $roleName)
                <span class="badge bg-primary-subtle text-primary rounded-pill fs-2 py-2 px-3 text-uppercase">{{ $roleName }}</span>
            @empty
                <span class="badge bg-secondary-subtle text-secondary rounded-pill fs-2 py-2 px-3">sin roles</span>
            @endforelse
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary rounded border-white border border-opacity-40 text-white d-flex align-items-center gap-2 px-3 py-2 fs-3">
                <i class="ti ti-logout fs-6"></i>
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
