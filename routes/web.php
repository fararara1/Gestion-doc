<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('documents', DocumentController::class);
    Route::resource('meetings', MeetingController::class);

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('categories', CategoryController::class);
    });

    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::post('documents/{document}/partage', [DocumentController::class, 'shareStore'])->name('documents.share.store');
    Route::delete('documents/{document}/partage/{user}', [DocumentController::class, 'shareDestroy'])->name('documents.share.destroy');
    Route::get('meetings/{meeting}/ics', [MeetingController::class, 'downloadIcs'])->name('meetings.ics');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->get('/test-email', function () {
        \Illuminate\Support\Facades\Mail::raw('Test email depuis GestDoc.', function ($message) {
            $message->to('test@example.com')->subject('Test email');
        });

        return back()->with('success', 'Email de test envoyé.');
    })->name('test.email');
});

require __DIR__.'/auth.php';
