<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Department;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;


        $projects = Project::with('department')
            ->when($search, function($query) use ($search){

                $query->where('nom','like',"%$search%");

            })
            ->latest()
            ->paginate(10);


        return view('projects.index', compact('projects'));
    }



    public function create()
    {
        $departments = Department::all();

        return view('projects.create', compact('departments'));
    }



    public function store(Request $request)
    {
        $request->validate([

            'nom'=>'required',
            'description'=>'nullable',
            'date_debut'=>'nullable|date',
            'date_fin'=>'nullable|date',
            'statut'=>'required',
            'department_id'=>'required'

        ]);


        Project::create($request->all());


        return redirect()
            ->route('projects.index')
            ->with('success','Projet ajouté avec succès.');
    }



    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }



    public function edit(Project $project)
    {
        $departments = Department::all();

        return view('projects.edit', compact(
            'project',
            'departments'
        ));
    }



    public function update(Request $request, Project $project)
    {
        $project->update($request->all());


        return redirect()
            ->route('projects.index')
            ->with('success','Projet modifié avec succès.');
    }



    public function destroy(Project $project)
    {
        $project->delete();


        return redirect()
            ->route('projects.index')
            ->with('success','Projet supprimé.');
    }

}