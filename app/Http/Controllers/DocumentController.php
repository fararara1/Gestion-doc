<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Http\Requests\ShareDocumentRequest;
use App\Models\Category;
use App\Models\Department;
use App\Models\Document;
use App\Models\Project;
use App\Models\User;
use App\Notifications\DocumentShared;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['user', 'project', 'category', 'department', 'sharedWith'])
            ->when(! auth()->user()->isAdmin(), function ($query) {
                $query->where(function ($q) {
                    $q->where('user_id', auth()->id())
                        ->orWhereHas('sharedWith', fn ($q2) => $q2->where('users.id', auth()->id()));
                });
            })
            ->when(request('recherche'), function ($query, $recherche) {
                $query->where('titre', 'like', "%{$recherche}%")
                    ->orWhere('description', 'like', "%{$recherche}%");
            })
            ->when(request('project_id'), fn ($query, $id) => $query->where('project_id', $id))
            ->when(request('category_id'), fn ($query, $id) => $query->where('category_id', $id))
            ->when(request('department_id'), fn ($query, $id) => $query->where('department_id', $id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        [$projects, $categories, $departments] = $this->selectLists();
        $allUsers = User::orderBy('nom')->get();

        return view('documents.index', compact('documents', 'projects', 'categories', 'departments', 'allUsers'));
    }

    public function create()
    {
        [$projects, $categories, $departments] = $this->selectLists();

        return view('documents.create', compact('projects', 'categories', 'departments'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('fichier')) {
            $data['fichier'] = $request->file('fichier')->store('documents', 'public');
        } else {
            $data['fichier'] = null;
        }

        Document::create($data);

        return redirect()->route('documents.index')
            ->with('success', 'Document ajouté avec succès.');
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);

        $document->load(['user', 'project', 'category', 'department', 'sharedWith']);

        $allUsers = User::orderBy('nom')->get();

        return view('documents.show', compact('document', 'allUsers'));
    }

    public function edit(Document $document)
    {
        $this->authorize('update', $document);

        [$projects, $categories, $departments] = $this->selectLists();

        return view('documents.edit', compact('document', 'projects', 'categories', 'departments'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $this->authorize('update', $document);

        $data = $request->validated();

        if ($request->hasFile('fichier')) {
            if ($document->fichier) {
                Storage::disk('public')->delete($document->fichier);
            }
            $data['fichier'] = $request->file('fichier')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')
            ->with('success', 'Document mis à jour avec succès.');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        Storage::disk('public')->delete($document->fichier);
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document supprimé avec succès.');
    }

    public function download(Document $document)
    {
        $this->authorize('view', $document);

        if (empty($document->fichier)) {
            abort(404, 'Aucun fichier associé à ce document.');
        }

        $path = Storage::disk('public')->path($document->fichier);

        if (! file_exists($path)) {
            abort(404, 'Fichier introuvable.');
        }

        $fileName = $document->titre . '.' . pathinfo($path, PATHINFO_EXTENSION);

        return response()->download($path, $fileName, [
            'Content-Type' => Storage::disk('public')->mimeType($document->fichier),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function shareStore(ShareDocumentRequest $request, Document $document)
    {
        $this->authorize('share', $document);

        $data = $request->validated();

        $pivotData = collect($data['user_ids'])
            ->mapWithKeys(fn ($id) => [$id => ['droit' => $data['droit']]])
            ->toArray();

        $document->sharedWith()->syncWithoutDetaching($pivotData);

        foreach ($data['user_ids'] as $userId) {
            $user = User::find($userId);
            if ($user) {
                $user->notify(new DocumentShared($document, auth()->user(), $data['droit']));
            }
        }

        return redirect()->route('documents.index')
            ->with('success', 'Document partagé avec succès.');
    }

    public function shareDestroy(Document $document, User $user)
    {
        $this->authorize('share', $document);

        $document->sharedWith()->detach($user->id);

        return redirect()->route('documents.index')
            ->with('success', 'Partage révoqué avec succès.');
    }

    public function markAllNotificationsAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }

    private function selectLists(): array
    {
        return [
            Project::orderBy('nom')->get(),
            Category::orderBy('nom')->get(),
            Department::orderBy('nom')->get()->unique('nom'),
        ];
    }
}
