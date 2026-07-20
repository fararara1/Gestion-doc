<section>
    <header>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--navy-900); margin: 0;">
            Modifier le mot de passe
        </h2>
        <p style="color: var(--navy-600); font-size: 0.9rem; margin-top: 6px;">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Mot de passe actuel</label>
            <input id="update_password_current_password" class="form-control" type="password" name="current_password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Nouveau mot de passe</label>
            <input id="update_password_password" class="form-control" type="password" name="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
            <input id="update_password_password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>

            @if (session('status') === 'password-updated')
                <p style="font-size: 0.88rem; color: var(--navy-600);">Enregistré.</p>
            @endif
        </div>
    </form>
</section>
