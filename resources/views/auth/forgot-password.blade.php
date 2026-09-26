<x-guest-layout>
    <p class="text-muted fs-3 mb-4">
        ¿Olvidaste tu contraseña? Indica tu correo y te enviaremos un enlace para elegir una nueva.
    </p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="email" value="Correo" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-primary-button class="w-100 py-8 fs-4 mb-4 rounded-2">Enviar enlace de restablecimiento</x-primary-button>

        <div class="d-flex align-items-center justify-content-center">
            <a class="text-primary fw-medium" href="{{ route('login') }}">Volver al inicio de sesión</a>
        </div>
    </form>
</x-guest-layout>
