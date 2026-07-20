<x-guest-layout>
    <div style="font-size: 0.92rem; color: var(--navy-600); line-height: 1.6;">
        Ceci est une zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="d-flex align-items-center justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                Confirmer
            </button>
        </div>
    </form>
</x-guest-layout>
