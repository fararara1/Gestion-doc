<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareDocumentRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Category;
use App\Models\Department;
use App\Models\Document;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Liste des documents.
     * Administrateur : voit tous les documents.
     * Collaborateur : voit uniquement ses documents + ceux partagés avec lui.
     */
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
            $query->where('titre', 'like', "%{$recherche}%");
        })
        ->when(request('project_id'), fn ($query, $id) => $query->where('project_id', $id))
        ->when(request('category_id'), fn ($query, $id) => $query->where('category_id', $id))
        ->when(request('department_id'), fn ($query, $id) => $query->where('department_id', $id))
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $projects = Project::orderBy('nom')->get();
    $categories = Category::orderBy('nom')->get();
    $departments = Department::orderBy('nom')->get();
    $allUsers = User::orderBy('nom')->get(); // pour peupler les modales de partage

    return view('documents.index', compact('documents', 'projects', 'categories', 'departments', 'allUsers'));
}

    public function create()
    {
        $projects = Project::orderBy('nom')->get();
        $categories = Category::orderBy('nom')->get();
        $departments = Department::orderBy('nom')->get();

        return view('documents.create', compact('projects', 'categories', 'departments'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $data['fichier'] = $request->file('fichier')->store('documents', 'public');
        $data['user_id'] = $request->user()->id;

        Document::create($data);

        return redirect()->route('documents.index')
            ->with('success', 'Document ajouté avec succès.');
    }

    /**
     * Consultation : autorisée à l'auteur, à l'administrateur,
     * ou à un utilisateur avec qui le document est partagé (lecture ou modification).
     */
    public function show(Document $document)
    {
        $this->authorizeView($document);

        $document->load(['user', 'project', 'category', 'department', 'sharedWith']);

        return view('documents.show', compact('document'));
    }

    /**
     * Modification : autorisée à l'auteur, à l'administrateur,
     * ou à un utilisateur partagé avec le droit "modification".
     */
    public function edit(Document $document)
    {
        $this->authorizeEdit($document);

        $projects = Project::orderBy('nom')->get();
        $categories = Category::orderBy('nom')->get();
        $departments = Department::orderBy('nom')->get();

        return view('documents.edit', compact('document', 'projects', 'categories', 'departments'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $this->authorizeEdit($document);

        $data = $request->validated();

        if ($request->hasFile('fichier')) {
            Storage::disk('public')->delete($document->fichier);
            $data['fichier'] = $request->file('fichier')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')
            ->with('success', 'Document mis à jour avec succès.');
    }

    /**
     * Suppression : réservée à l'auteur ou à l'administrateur (jamais aux utilisateurs partagés).
     */
    public function destroy(Document $document)
    {
        if (! auth()->user()->isAdmin() && auth()->id() !== $document->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce document.');
        }

        Storage::disk('public')->delete($document->fichier);
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document supprimé avec succès.');
    }

    public function download(Document $document)
    {
        $this->authorizeView($document);

        if (! Storage::disk('public')->exists($document->fichier)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('public')->download($document->fichier, $document->titre);
    }

    /**
     * Formulaire de partage d'un document.
     */
  

    /**
     * Enregistre le partage (ajout ou mise à jour du droit) pour les utilisateurs sélectionnés.
     */
   public function shareStore(ShareDocumentRequest $request, Document $document)
{
    $data = $request->validated();

    $pivotData = collect($data['user_ids'])
        ->mapWithKeys(fn ($id) => [$id => ['droit' => $data['droit']]])
        ->toArray();

    $document->sharedWith()->syncWithoutDetaching($pivotData);

    return redirect()->route('documents.index')
        ->with('success', 'Document partagé avec succès.');
}

public function shareDestroy(Document $document, User $user)
{
    if (! auth()->user()->isAdmin() && auth()->id() !== $document->user_id) {
        abort(403, 'Vous n\'êtes pas autorisé à modifier le partage de ce document.');
    }

    $document->sharedWith()->detach($user->id);

    return redirect()->route('documents.index')
        ->with('success', 'Partage révoqué avec succès.');
}
    /**
     * Vérifie que l'utilisateur peut consulter le document (auteur, admin, ou partagé).
     */
    private function authorizeView(Document $document): void
    {
        $user = auth()->user();

        $isShared = $document->sharedWith()->where('users.id', $user->id)->exists();

        if (! $user->isAdmin() && $user->id !== $document->user_id && ! $isShared) {
            abort(403, 'Vous n\'avez pas accès à ce document.');
        }
    }

    /**
     * Vérifie que l'utilisateur peut modifier le document
     * (auteur, admin, ou partagé avec le droit "modification").
     */
    private function authorizeEdit(Document $document): void
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->id === $document->user_id) {
            return;
        }

        $hasEditRight = $document->sharedWith()
            ->where('users.id', $user->id)
            ->wherePivot('droit', 'modification')
            ->exists();

        if (! $hasEditRight) {
            abort(403, 'Vous n\'avez pas le droit de modifier ce document.');
        }
    }
}