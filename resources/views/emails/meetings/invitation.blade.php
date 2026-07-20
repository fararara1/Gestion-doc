<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invitation à une réunion</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.04), 0 1px 2px -1px rgb(0 0 0 / 0.04); border: 1px solid #e2e8f0;">
                    <tr>
                        <td style="padding: 40px; text-align: center; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%); color: #ffffff; border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; font-size: 24px; font-family: 'Playfair Display', Georgia, serif;">{{ config('app.name', 'GestDoc') }}</h1>
                            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Invitation à une réunion</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <p>Bonjour,</p>
                            <p>Vous êtes invité(e) à la réunion suivante :</p>

                            <h2 style="color: #0f172a; margin-top: 30px; font-family: 'Playfair Display', Georgia, serif;">{{ $meeting->titre }}</h2>

                            @if($meeting->description)
                            <div style="background-color: #fefce8; padding: 20px; border-radius: 12px; margin: 20px 0; border: 1px solid #fef08a;">
                                <h3 style="margin-top: 0; color: #475569; font-family: 'Playfair Display', Georgia, serif;">Ordre du jour</h3>
                                <p style="color: #334155; line-height: 1.6;">{!! nl2br(e($meeting->description)) !!}</p>
                            </div>
                            @endif

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td style="padding: 15px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                        <strong style="color: #475569;">Date :</strong>
                                        <span style="color: #1e293b;">{{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }}</span>
                                    </td>
                                </tr>
                                <tr><td style="height: 10px;"></td></tr>
                                <tr>
                                    <td style="padding: 15px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                        <strong style="color: #475569;">Heure :</strong>
                                        <span style="color: #1e293b;">{{ \Carbon\Carbon::parse($meeting->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($meeting->heure_fin)->format('H:i') }}</span>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #1e293b; font-family: 'Playfair Display', Georgia, serif;">Participants</h3>
                            <ul style="color: #334155; line-height: 1.8;">
                                @foreach($meeting->participants as $participant)
                                <li><strong>{{ $participant->prenom }} {{ $participant->nom }}</strong> — {{ $participant->email }}</li>
                                @endforeach
                            </ul>

                            @if($meeting->documents->count() > 0)
                            <h3 style="color: #1e293b; margin-top: 30px; font-family: 'Playfair Display', Georgia, serif;">Documents associés</h3>
                            <ul style="color: #334155; line-height: 1.8;">
                                @foreach($meeting->documents as $document)
                                <li>{{ $document->titre }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <div style="text-align: center; margin: 40px 0;">
                                <a href="{{ rtrim(config('app.url'), '/') . '/meetings/' . $meeting->id . '?redirect=' . urlencode(rtrim(config('app.url'), '/') . '/meetings/' . $meeting->id) }}"
                                   style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%); color: #0f172a; text-decoration: none; border-radius: 12px; font-weight: 700; font-family: 'Inter', sans-serif;">
                                     Voir la réunion
                                </a>
                            </div>

                            <p style="color: #64748b; font-size: 14px; margin-top: 40px;">
                                Merci,<br>
                                <strong>{{ config('app.name', 'GestDoc') }}</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; text-align: center; background-color: #f8fafc; border-radius: 0 0 12px 12px; border-top: 1px solid #f1f5f9;">
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                Vous recevez cet email automatiquement. Merci de ne pas y répondre.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
