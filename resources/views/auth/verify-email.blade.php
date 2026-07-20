<x-guest-layout>
    <div style="font-size: 0.92rem; color: var(--navy-600); line-height: 1.6;">
        Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, nous pouvons vous en renvoyer un autre.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de l'inscription.
        </div>
    @endif

    <div class="mt-4 d-flex align-items-center justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="btn btn-primary">
                    Renvoyer l'email
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" style="font-size: 0.88rem; color: var(--navy-600); font-weight: 500; background: none; border: none; cursor: pointer; text-decoration: none;">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
