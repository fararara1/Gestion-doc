<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invitation à une réunion</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="padding: 40px; text-align: center; background-color: #2563eb; color: #ffffff; border-radius: 8px 8px 0 0;">
                            <h1 style="margin: 0; font-size: 24px;">{{ config('app.name', 'GestDoc') }}</h1>
                            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Invitation à une réunion</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <p>Bonjour,</p>
                            <p>Vous êtes invité(e) à la réunion suivante :</p>
                            
                            <h2 style="color: #1e293b; margin-top: 30px;">{{ $meeting->titre }}</h2>
                            
                            @if($meeting->description)
                            <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
                                <h3 style="margin-top: 0; color: #475569;">Ordre du jour</h3>
                                <p style="color: #334155; line-height: 1.6;">{!! nl2br(e($meeting->description)) !!}</p>
                            </div>
                            @endif

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td style="padding: 15px; background-color: #f8fafc; border-radius: 8px;">
                                        <strong style="color: #475569;">Date :</strong>
                                        <span style="color: #1e293b;">{{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }}</span>
                                    </td>
                                </tr>
                                <tr><td style="height: 10px;"></td></tr>
                                <tr>
                                    <td style="padding: 15px; background-color: #f8fafc; border-radius: 8px;">
                                        <strong style="color: #475569;">Heure :</strong>
                                        <span style="color: #1e293b;">{{ \Carbon\Carbon::parse($meeting->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($meeting->heure_fin)->format('H:i') }}</span>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #1e293b;">Participants</h3>
                            <ul style="color: #334155; line-height: 1.8;">
                                @foreach($meeting->participants as $participant)
                                <li><strong>{{ $participant->prenom }} {{ $participant->nom }}</strong> — {{ $participant->email }}</li>
                                @endforeach
                            </ul>

                            @if($meeting->documents->count() > 0)
                            <h3 style="color: #1e293b; margin-top: 30px;">Documents associés</h3>
                            <ul style="color: #334155; line-height: 1.8;">
                                @foreach($meeting->documents as $document)
                                <li>{{ $document->titre }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <div style="text-align: center; margin: 40px 0;">
                                <a href="{{ rtrim(config('app.url'), '/') . '/meetings/' . $meeting->id . '?redirect=' . urlencode(rtrim(config('app.url'), '/') . '/meetings/' . $meeting->id) }}" 
                                   style="display: inline-block; padding: 14px 32px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">
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
                        <td style="padding: 20px; text-align: center; background-color: #f8fafc; border-radius: 0 0 8px 8px;">
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
