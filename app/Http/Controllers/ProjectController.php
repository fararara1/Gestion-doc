<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('documents')
            ->orderBy('nom')
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        Project::create($request->validated());

        return redirect()->route('projects.index')
            ->with('success', 'Projet créé avec succès.');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    public function destroy(Project $project)
    {
        // Empêcher la suppression d'un projet encore lié à des documents
        if ($project->documents()->exists()) {
            return redirect()->route('projects.index')
                ->with('error', 'Impossible de supprimer ce projet : des documents y sont rattachés.');
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Projet supprimé avec succès.');
    }
}