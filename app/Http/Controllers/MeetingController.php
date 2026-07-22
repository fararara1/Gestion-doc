<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Document;
use App\Models\Meeting;
use App\Models\User;
use App\Mail\MeetingInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with(['organisateur', 'participants'])
            ->when(! auth()->user()->isAdmin(), function ($query) {
                $query->where(function ($q) {
                    $q->where('user_id', auth()->id())
                        ->orWhereHas('participants', fn ($q2) => $q2->where('users.id', auth()->id()));
                });
            })
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->paginate(10);

        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $this->authorize('create', Meeting::class);

        $users = User::orderBy('nom')->get();
        $documents = Document::orderBy('titre')->get();

        return view('meetings.create', compact('users', 'documents'));
    }

    public function store(StoreMeetingRequest $request)
    {
        $this->authorize('create', Meeting::class);

        $validated = $request->validated();

        $meeting = Meeting::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'date' => $validated['date'],
            'heure_debut' => $validated['heure_debut'],
            'heure_fin' => $validated['heure_fin'],
            'user_id' => auth()->id(),
        ]);

        $meeting->participants()->sync($validated['participant_ids'] ?? []);
        $meeting->documents()->sync($validated['document_ids'] ?? []);

        $this->sendInvitations($meeting);

        return redirect()->route('meetings.index')
            ->with('success', 'Réunion créée avec succès. Les invitations ont été envoyées.');
    }

    public function show(Meeting $meeting)
    {
        $this->authorize('view', $meeting);

        $meeting->load(['organisateur', 'participants', 'documents']);

        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $users = User::orderBy('nom')->get();
        $documents = Document::orderBy('titre')->get();

        return view('meetings.edit', compact('meeting', 'users', 'documents'));
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $data = $request->validated();

        $meeting->update($data);

        $meeting->participants()->sync($data['participant_ids']);
        $meeting->documents()->sync($data['document_ids'] ?? []);

        $this->sendInvitations($meeting);

        return redirect()->route('meetings.index')
            ->with('success', 'Réunion mise à jour avec succès. Les invitations ont été renvoyées.');
    }

    public function destroy(Meeting $meeting)
    {
        $this->authorize('delete', $meeting);

        $meeting->delete();

        return redirect()->route('meetings.index')
            ->with('success', 'Réunion supprimée avec succès.');
    }

    public function downloadIcs(Meeting $meeting)
    {
        $this->authorize('view', $meeting);

        $fileName = 'reunion-' . $meeting->id . '-' . Str::slug($meeting->titre) . '.ics';

        return response($meeting->toIcs(), 200)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    private function sendInvitations(Meeting $meeting): void
    {
        $meeting->loadMissing(['organisateur', 'participants', 'documents']);

        foreach ($meeting->participants as $participant) {
            Mail::to($participant->email)->send(new MeetingInvitation($meeting));
        }
    }
}
