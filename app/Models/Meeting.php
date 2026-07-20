<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meeting extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'date',
        'heure_debut',
        'heure_fin',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'heure_debut' => 'datetime:H:i',
            'heure_fin' => 'datetime:H:i',
        ];
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'meeting_user')
            ->withTimestamps();
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'document_meeting')
            ->withTimestamps();
    }

    public function organisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toIcs(): string
    {
        $start = $this->date->format('Ymd') . substr($this->heure_debut->format('H:i'), 0, 5);
        $end = $this->date->format('Ymd') . substr($this->heure_fin->format('H:i'), 0, 5);
        $uid = uniqid('meeting-' . $this->id . '-', false) . '@gestdoc';

        $escapeIcs = function (string $value): string {
            $value = str_replace(["\r\n", "\n", "\r"], '\\n', $value);
            return addcslashes($value, ",;'");
        };

        $organisateur = ($this->organisateur->prenom ?? '') . ' ' . ($this->organisateur->nom ?? '');

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//GestDoc//FR',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:' . $uid,
            'DTSTAMP:' . now()->format('Ymd\THis'),
            'DTSTART;TZID=Europe/Paris:' . $start,
            'DTEND;TZID=Europe/Paris:' . $end,
            'SUMMARY:' . $escapeIcs($this->titre),
            'DESCRIPTION:' . $escapeIcs(nl2br(e($this->description ?? ''))),
            'ORGANIZER;CN=' . $escapeIcs($organisateur) . ':mailto:' . ($this->organisateur->email ?? ''),
        ];

        foreach ($this->participants as $participant) {
            $lines[] = 'ATTENDEE;CN=' . $escapeIcs($participant->prenom . ' ' . $participant->nom) . ':mailto:' . $participant->email;
        }

        $lines[] = 'END:VEVENT';
        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines);
    }
}
