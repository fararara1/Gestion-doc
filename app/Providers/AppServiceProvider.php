<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['documents.*', 'users.*', 'projects.*'],
            function ($view) {
                $view->with('departments', Department::orderBy('nom')->get()->unique('nom'));
            }
        );

        View::composer('documents.*', function ($view) {
            $view->with([
                'projects' => Project::orderBy('nom')->get(),
                'categories' => Category::orderBy('nom')->get(),
                'allUsers' => User::orderBy('nom')->get(),
            ]);
        });

        View::composer('meetings.*', function ($view) {
            $view->with([
                'users' => User::orderBy('nom')->get(),
                'documents' => \App\Models\Document::orderBy('titre')->get(),
            ]);
        });
    }
}
