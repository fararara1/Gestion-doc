<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $documentsCount = Document::count();
            $meetingsCount = Meeting::count();
            $projectsCount = Project::count();
            $usersCount = User::count();

            $recentDocuments = Document::latest()->take(5)->get();
            $upcomingMeetings = Meeting::orderBy('date')->take(5)->get();
        } else {
            $documentsCount = Document::where('user_id', $user->id)
                ->orWhereHas('sharedWith', fn ($q) => $q->where('users.id', $user->id))
                ->count();

            $meetingsCount = Meeting::where('user_id', $user->id)
                ->orWhereHas('participants', fn ($q) => $q->where('users.id', $user->id))
                ->count();

            $projectsCount = Project::where('department_id', $user->department_id)->count();

            $usersCount = User::where('department_id', $user->department_id)->count();

            $recentDocuments = Document::where('user_id', $user->id)
                ->orWhereHas('sharedWith', fn ($q) => $q->where('users.id', $user->id))
                ->latest()
                ->take(5)
                ->get();

            $upcomingMeetings = Meeting::where('user_id', $user->id)
                ->orWhereHas('participants', fn ($q) => $q->where('users.id', $user->id))
                ->orderBy('date')
                ->take(5)
                ->get();
        }

        return view('dashboard', compact(
            'usersCount',
            'projectsCount',
            'documentsCount',
            'meetingsCount',
            'recentDocuments',
            'upcomingMeetings'
        ));
    }
}
