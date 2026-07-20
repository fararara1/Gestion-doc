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
            $stats = $this->adminStats();
        } else {
            $stats = $this->userStats($user);
        }

        return view('dashboard', $stats);
    }

    private function adminStats(): array
    {
        return [
            'usersCount' => User::count(),
            'projectsCount' => Project::count(),
            'documentsCount' => Document::count(),
            'meetingsCount' => Meeting::count(),
            'recentDocuments' => Document::latest()->take(5)->get(),
            'upcomingMeetings' => Meeting::where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->take(5)
                ->get(),
        ];
    }

    private function userStats(User $user): array
    {
        $documentQuery = Document::where('user_id', $user->id)
            ->orWhereHas('sharedWith', fn ($q) => $q->where('users.id', $user->id));

        $meetingQuery = Meeting::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('participants', fn ($q2) => $q2->where('users.id', $user->id));
            })
            ->where('date', '>=', now()->toDateString());

        return [
            'documentsCount' => $documentQuery->count(),
            'meetingsCount' => Meeting::where('user_id', $user->id)
                ->orWhereHas('participants', fn ($q) => $q->where('users.id', $user->id))
                ->count(),
            'projectsCount' => Project::where('department_id', $user->department_id)->count(),
            'usersCount' => User::where('department_id', $user->department_id)->count(),
            'recentDocuments' => $documentQuery->latest()->take(5)->get(),
            'upcomingMeetings' => $meetingQuery->orderBy('date')->take(5)->get(),
        ];
    }
}
