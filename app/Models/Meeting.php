<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;

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
        ];
    }

    // Participants
    public function participants()
    {
        return $this->belongsToMany(User::class, 'meeting_user')
            ->withTimestamps();
    }

    // Documents associés
    public function documents()
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
        $start = \Carbon\Carbon::parse($this->date . ' ' . $this->heure_debut)->format('Ymd\THis');
        $end = \Carbon\Carbon::parse($this->date . ' ' . $this->heure_fin)->format('Ymd\THis');
        $uid = uniqid('meeting-' . $this->id . '-', false) . '@gestdoc';

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
            'SUMMARY:' . addcslashes($this->titre, ','),
            'DESCRIPTION:' . addcslashes(nl2br(e($this->description ?? '')), ','),
            'ORGANIZER;CN=' . addcslashes(($this->organisateur?->prenom ?? '') . ' ' . ($this->organisateur?->nom ?? ''), ',') . ':mailto:' . ($this->organisateur?->email ?? ''),
        ];

        foreach ($this->participants as $participant) {
            $lines[] = 'ATTENDEE;CN=' . addcslashes($participant->prenom . ' ' . $participant->nom, ',') . ':mailto:' . $participant->email;
        }

        $lines[] = 'END:VEVENT';
        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines);
    }
}
