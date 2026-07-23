<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProfileController;
use App\Models\Document;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/health', [\App\Http\Controllers\HealthController::class, 'index']);

Route::get('/diagnostic', function () {
    try {
        $dbStatus = DB::connection()->getPdo() ? 'OK' : 'FAIL';
    } catch (\Throwable $e) {
        $dbStatus = 'ERROR: ' . $e->getMessage();
    }

    return response()->json([
        'app' => config('app.name'),
        'env' => config('app.env'),
        'debug' => config('app.debug'),
        'url' => config('app.url'),
        'database' => $dbStatus,
        'session_driver' => config('session.driver'),
        'cache_driver' => config('cache.default'),
    ]);
})->name('diagnostic');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('documents', DocumentController::class);
    Route::get('meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::middleware('admin')->group(function () {
        Route::get('meetings/create', [MeetingController::class, 'create'])->name('meetings.create');
        Route::post('meetings', [MeetingController::class, 'store'])->name('meetings.store');
        Route::get('meetings/{meeting}/edit', [MeetingController::class, 'edit'])->name('meetings.edit');
        Route::put('meetings/{meeting}', [MeetingController::class, 'update'])->name('meetings.update');
        Route::delete('meetings/{meeting}', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    });
    Route::get('meetings/{meeting}/ics', [MeetingController::class, 'downloadIcs'])->name('meetings.ics');
    Route::get('meetings/{meeting}', [MeetingController::class, 'show'])->name('meetings.show');

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('categories', CategoryController::class);
    });

    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::post('documents/{document}/partage', [DocumentController::class, 'shareStore'])->name('documents.share.store');
    Route::get('documents/{document}/partage', function (Document $document) {
        return redirect()->route('documents.index');
    })->name('documents.share.redirect');
    Route::delete('documents/{document}/partage/{user}', [DocumentController::class, 'shareDestroy'])->name('documents.share.destroy');
    Route::post('notifications/mark-all-read', [DocumentController::class, 'markAllNotificationsAsRead'])->name('notifications.markAllRead');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
