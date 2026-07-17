<x-guest-layout>
    <div class="mb-4" style="font-size: 0.92rem; color: var(--navy-600); line-height: 1.6;">
        Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, nous pouvons vous en renvoyer un autre.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" style="border-radius: var(--radius-sm); margin-bottom: 20px; background: #fefce8; border-left: 4px solid var(--gold-500); color: var(--gold-700);">
            Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de l'inscription.
        </div>
    @endif

    <div class="mt-4 d-flex align-items-center justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="btn-auth" style="width: auto; padding: 10px 24px; margin-top: 0;">
                    Renvoyer l'email
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-decoration-none" style="font-size: 0.88rem; color: var(--navy-600); font-weight: 500; background: none; border: none; cursor: pointer;">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
