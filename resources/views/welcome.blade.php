<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Dacota') }} &mdash; Autenticación y roles</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>

<body>
    <div class="min-vh-100 d-flex flex-column">
        <div class="app-topstrip bg-dark py-3 px-4 w-100 d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="text-white d-flex align-items-center gap-2">
                <i class="ti ti-shield-check fs-5"></i>
                <span class="fs-3 fw-semibold">{{ config('app.name', 'Dacota') }}</span>
            </a>

            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded border-white border border-opacity-40 text-white d-flex align-items-center gap-2 px-3 py-2 fs-3">
                Ingresar
            </a>
        </div>

        <div class="flex-grow-1 d-flex align-items-center">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <div class="card">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div class="d-flex justify-content-center mb-4">
                                    <x-application-logo class="justify-content-center" />
                                </div>

                                <h1 class="mb-3">Panel de autenticación y roles</h1>
                                <p class="text-muted fs-3 mb-4">
                                    Sistema con inicio de sesión, usuarios, roles y permisos controlados por
                                    spatie/laravel-permission.
                                </p>

                                <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                                    <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2">
                                        <i class="ti ti-login me-1"></i> Iniciar sesión
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary px-4 py-2">
                                        <i class="ti ti-user-plus me-1"></i> Crear cuenta
                                    </a>
                                </div>

                                <div class="row g-3 text-start">
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-2 bg-primary-subtle h-100">
                                            <i class="ti ti-shield-lock fs-3 text-primary"></i>
                                            <h3 class="fs-4 mt-2 mb-1">Roles</h3>
                                            <p class="fs-3 text-muted mb-0">admin, editor y user con permisos diferenciados.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-2 bg-info-subtle h-100">
                                            <i class="ti ti-key fs-3 text-info"></i>
                                            <h3 class="fs-4 mt-2 mb-1">Permisos</h3>
                                            <p class="fs-3 text-muted mb-0">Control granular por recurso y acción.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-2 bg-success-subtle h-100">
                                            <i class="ti ti-users fs-3 text-success"></i>
                                            <h3 class="fs-4 mt-2 mb-1">Usuarios</h3>
                                            <p class="fs-3 text-muted mb-0">Alta, edición y asignación de roles.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-4 px-4 text-center">
            <p class="mb-0 fs-3 text-muted">{{ config('app.name', 'Dacota') }} &mdash; Laravel {{ Illuminate\Foundation\Application::VERSION }}</p>
        </footer>
    </div>
</body>

</html>
