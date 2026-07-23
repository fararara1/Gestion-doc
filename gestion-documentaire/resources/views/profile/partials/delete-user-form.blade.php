<section>
    <header>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--navy-900); margin: 0;">
            Supprimer le compte
        </h2>
        <p style="color: var(--navy-600); font-size: 0.9rem; margin-top: 6px;">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données que vous souhaitez conserver.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Supprimer le compte</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: var(--navy-900); margin: 0;">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h2>

            <p style="color: var(--navy-600); font-size: 0.9rem; margin-top: 6px;">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
            </p>

            <div class="mt-4">
                <label for="password" class="form-label sr-only">Mot de passe</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="Mot de passe"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 d-flex justify-content-end">
                <button type="button" x-on:click="$dispatch('close')" class="btn btn-outline-secondary">
                    Annuler
                </button>

                <button type="submit" class="btn btn-danger ms-3">
                    Supprimer le compte
                </button>
            </div>
        </form>
    </x-modal>
</section>
