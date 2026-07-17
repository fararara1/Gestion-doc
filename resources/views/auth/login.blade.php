<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3">
            <label for="remember_me" class="form-check-label" style="font-size: 0.9rem; color: var(--navy-600); cursor: pointer;">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                Se souvenir de moi
            </label>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-decoration-none" style="font-size: 0.88rem; color: var(--gold-700); font-weight: 600;" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif

            <button type="submit" class="btn-auth" style="width: auto; padding: 10px 24px; margin-top: 0;">
                {{ __('Se connecter') }}
            </button>
        </div>
    </form>
</x-guest-layout>
