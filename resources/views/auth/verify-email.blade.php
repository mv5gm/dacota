<x-guest-layout>
    <p class="text-muted fs-3 mb-4">
        ¡Gracias por registrarte! Antes de comenzar, confirma tu correo electrónico usando el enlace que te enviamos.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success py-2 px-3 mb-4 fs-3">
            Se envió un nuevo enlace de verificación al correo que registraste.
        </div>
    @endif

    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Reenviar correo de verificación</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">Cerrar sesión</button>
        </form>
    </div>
</x-guest-layout>
