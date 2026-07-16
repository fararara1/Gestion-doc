<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Document;
use App\Models\Meeting;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'usersCount' => User::count(),
            'projectsCount' => Project::count(),
            'documentsCount' => Document::count(),
            'meetingsCount' => Meeting::count(),

            'recentDocuments' => Document::latest()->take(5)->get(),

            'upcomingMeetings' => Meeting::orderBy('date')
                ->take(5)
                ->get(),
        ]);
    }
}