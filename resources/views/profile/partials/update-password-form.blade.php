<section>
    <h4 class="card-title mb-1">Actualizar contraseña</h4>
    <p class="card-subtitle mb-4">Usa una contraseña larga y aleatoria para mantener la cuenta segura.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row g-3">
            <div class="col-md-4">
                <x-input-label for="update_password_current_password" value="Contraseña actual" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" />
            </div>

            <div class="col-md-4">
                <x-input-label for="update_password_password" value="Nueva contraseña" />
                <x-text-input id="update_password_password" name="password" type="password" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" />
            </div>

            <div class="col-md-4">
                <x-input-label for="update_password_password_confirmation" value="Confirmar contraseña" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <x-primary-button>Guardar</x-primary-button>

            @if (session('status') === 'password-updated')
                <p class="fs-3 text-success mb-0">Contraseña actualizada.</p>
            @endif
        </div>
    </form>
</section>
