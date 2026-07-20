<section>
    <header>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--navy-900); margin: 0;">
            Informations du profil
        </h2>
        <p style="color: var(--navy-600); font-size: 0.9rem; margin-top: 6px;">
            Mettez à jour les informations de votre compte et votre adresse email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input id="name" class="form-control" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p style="font-size: 0.88rem; color: var(--navy-600);">
                        Votre adresse email n'est pas vérifiée.

                        <button form="send-verification" style="font-size: 0.88rem; color: var(--gold-700); font-weight: 600; background: none; border: none; cursor: pointer; text-decoration: underline;">
                            Cliquez ici pour renvoyer l'email de vérification.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2" style="font-size: 0.88rem; font-weight: 600; color: #15803d;">
                            Un nouveau lien de vérification a été envoyé à votre adresse email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>

            @if (session('status') === 'profile-updated')
                <p style="font-size: 0.88rem; color: var(--navy-600);">Enregistré.</p>
            @endif
        </div>
    </form>
</section>
