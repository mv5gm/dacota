<section>
    <h4 class="card-title mb-1">Eliminar cuenta</h4>
    <p class="card-subtitle mb-4">
        Una vez eliminada la cuenta se perderán todos sus datos de forma permanente. Descarga antes cualquier
        información que necesites conservar.
    </p>

    <x-danger-button data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        <i class="ti ti-trash me-1"></i> Eliminar cuenta
    </x-danger-button>

    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-user-deletion-label">¿Eliminar tu cuenta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <p class="fs-3 text-muted">
                            Todos los datos de la cuenta se eliminarán de forma permanente. Ingresa tu contraseña
                            para confirmar la acción.
                        </p>

                        <div class="mt-3">
                            <x-input-label for="password" value="Contraseña" />
                            <x-text-input id="password" name="password" type="password" placeholder="Contraseña" />
                            <x-input-error :messages="$errors->userDeletion->get('password')" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <x-danger-button>Eliminar cuenta</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
