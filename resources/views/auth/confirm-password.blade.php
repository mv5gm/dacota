<x-guest-layout>
    <p class="text-muted fs-3 mb-4">
        Esta es un área segura del sistema. Confirma tu contraseña para continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button class="w-100 py-8 fs-4 mb-4 rounded-2">Confirmar</x-primary-button>
    </form>
</x-guest-layout>
