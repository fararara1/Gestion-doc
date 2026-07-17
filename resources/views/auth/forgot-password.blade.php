<x-guest-layout>
    <div class="mb-4" style="font-size: 0.92rem; color: var(--navy-600); line-height: 1.6;">
        Mot de passe oublié ? Aucun problème. Indiquez simplement votre adresse email et nous vous enverrons un lien de réinitialisation.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="d-flex align-items-center justify-content-end mt-4">
            <button type="submit" class="btn-auth" style="width: auto; padding: 10px 24px; margin-top: 0;">
                Envoyer le lien
            </button>
        </div>
    </form>
</x-guest-layout>
