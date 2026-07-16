<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Document;
use App\Models\Meeting;
use App\Models\User;
use App\Mail\MeetingInvitation;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    /**
     * Liste des réunions.
     * Administrateur : voit toutes les réunions.
     * Collaborateur : voit celles qu'il organise + celles où il est participant.
     */
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
        $users = User::orderBy('nom')->get();
        $documents = Document::orderBy('titre')->get();

        return view('meetings.create', compact('users', 'documents'));
    }

    public function store(StoreMeetingRequest $request)
{
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

    $meeting->load(['participants', 'documents']);

    foreach ($meeting->participants as $participant) {
        Mail::to($participant->email)->queue(new MeetingInvitation($meeting));
    }

    return redirect()->route('meetings.index')
        ->with('success', 'Réunion créée avec succès. Les invitations ont été envoyées.');
}
    public function show(Meeting $meeting)
    {
        $this->authorizeAccess($meeting);

        $meeting->load(['organisateur', 'participants', 'documents']);

        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        if (! auth()->user()->isAdmin() && auth()->id() !== $meeting->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette réunion.');
        }

        $meeting->load(['participants', 'documents']);
        $users = User::orderBy('nom')->get();
        $documents = Document::orderBy('titre')->get();

        return view('meetings.edit', compact('meeting', 'users', 'documents'));
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
{
    $data = $request->validated();

    $meeting->update($data);

    $meeting->participants()->sync($data['participant_ids']);
    $meeting->documents()->sync($data['document_ids'] ?? []);

    // Renvoie l'invitation mise à jour à tous les participants actuels
    $meeting->load(['participants', 'documents']);

    foreach ($meeting->participants as $participant) {
        Mail::to($participant->email)->send(new MeetingInvitation($meeting));
    }

    return redirect()->route('meetings.index')
        ->with('success', 'Réunion mise à jour avec succès. Les invitations ont été renvoyées.');
}

    public function destroy(Meeting $meeting)
    {
        if (! auth()->user()->isAdmin() && auth()->id() !== $meeting->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette réunion.');
        }

        $meeting->delete();

        return redirect()->route('meetings.index')
            ->with('success', 'Réunion supprimée avec succès.');
    }

    /**
     * Vérifie que l'utilisateur peut consulter la réunion (organisateur, admin, ou participant).
     */
    private function authorizeAccess(Meeting $meeting): void
    {
        $user = auth()->user();

        $isParticipant = $meeting->participants()->where('users.id', $user->id)->exists();

        if (! $user->isAdmin() && $user->id !== $meeting->user_id && ! $isParticipant) {
            abort(403, 'Vous n\'avez pas accès à cette réunion.');
        }
    }
}