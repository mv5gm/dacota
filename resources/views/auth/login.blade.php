<x-guest-layout>
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="login" value="Usuario o correo" />
            <x-text-input id="login" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="admin" />
            <x-input-error :messages="$errors->get('login')" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="12345678" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input primary" type="checkbox" name="remember" value="1" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-dark" for="remember_me">Recordarme</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-primary fw-medium" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <x-primary-button class="w-100 py-8 fs-4 mb-4 rounded-2">Ingresar</x-primary-button>

        <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-medium">¿Nuevo en el sistema?</p>
            <a class="text-primary fw-medium ms-2" href="{{ route('register') }}">Crear una cuenta</a>
        </div>
    </form>

    <div class="rounded-2 bg-light border p-3 mt-4">
        <p class="mb-1 fs-3 fw-semibold text-dark">Usuario de prueba</p>
        <p class="mb-0 fs-3 text-muted">Usuario: <span class="font-monospace text-dark">admin</span> &mdash; Contraseña: <span class="font-monospace text-dark">12345678</span></p>
    </div>
</x-guest-layout>
