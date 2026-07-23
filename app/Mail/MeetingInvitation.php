<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public Meeting $meeting;
    public string $platformUrl;

    public function __construct(Meeting $meeting, ?string $platformUrl = null)
    {
        $this->meeting = $meeting;
        $this->platformUrl = $platformUrl ?? config('app.url');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à la réunion : ' . $this->meeting->titre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meetings.invitation',
        );
    }

    public function attachments(): array
    {
        $fileName = 'reunion-' . $this->meeting->id . '-' . \Illuminate\Support\Str::slug($this->meeting->titre) . '.ics';

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn () => $this->meeting->toIcs(),
                $fileName
            )->withMime('text/calendar'),
        ];
    }
}