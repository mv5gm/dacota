<section>
    <h4 class="card-title mb-1">Información del perfil</h4>
    <p class="card-subtitle mb-4">Actualiza tu nombre, usuario, correo y contraseña de la cuenta.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="row g-3">
            <div class="col-md-4">
                <x-input-label for="name" value="Nombre" />
                <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="col-md-4">
                <x-input-label for="username" value="Usuario" />
                <x-text-input id="username" name="username" type="text" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" />
            </div>

            <div class="col-md-4">
                <x-input-label for="email" value="Correo" />
                <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="fs-3 text-muted mb-1">
                            Tu correo no está verificado.
                            <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline">
                                Reenviar correo de verificación
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="fs-3 text-success mb-0">Se envió un nuevo enlace de verificación.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <x-primary-button>Guardar</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="fs-3 text-success mb-0">Cambios guardados.</p>
            @endif
        </div>
    </form>
</section>
