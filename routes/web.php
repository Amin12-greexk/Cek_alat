<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Admin\ToolPartController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Models\Tool;
use App\Http\Controllers\WorkerController;


Route::get('/', function () {
    return redirect()->route('worker.tools.index');
});


// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/worker/tools/{tool}/submit', [WorkerController::class, 'submitInspection'])->name('worker.tools.submit');
Route::get('/worker/tools', [WorkerController::class, 'tools'])->name('worker.tools.index');
Route::get('/worker/tools/{tool}/inspect', [WorkerController::class, 'inspect'])->name('worker.tools.inspect');
Route::post('/worker/tools/{tool}/submit', [WorkerController::class, 'submitInspection'])->name('worker.tools.submit');
Route::get('/worker/tools/download', [WorkerController::class, 'downloadFeasibleSubmissions'])->name('worker.tools.download');
Route::get('/worker/submission/{submission}/export', [WorkerController::class, 'exportSubmission'])->name('worker.submission.export');
// Admin Routes with Prefix and Name
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        $totalTools = \App\Models\Tool::count();
        $totalParts = \App\Models\ToolPart::count();
        $totalSubmissions = \App\Models\Submission::count();

        return view('admin.dashboard', compact('totalTools', 'totalParts', 'totalSubmissions'));
    })->name('dashboard');

    // Tools Management Routes
    Route::resource('tools', ToolController::class);

    // Tool Parts Management Routes
    Route::get('/tools/{tool}/parts', [ToolPartController::class, 'index'])->name('tools.parts.index');
    Route::post('/tools/{tool}/parts', [ToolPartController::class, 'store'])->name('tools.parts.store');
    Route::get('/tools/{tool}/parts/{part}/edit', [ToolPartController::class, 'edit'])->name('tools.parts.edit');
    Route::put('/tools/{tool}/parts/{part}', [ToolPartController::class, 'update'])->name('tools.parts.update');
    Route::delete('/tools/parts/{part}', [ToolPartController::class, 'destroy'])->name('tools.parts.destroy');
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::post('/submissions/{submission}/update-status', [SubmissionController::class, 'updateStatus'])->name('submissions.update-status');
    
});

Route::get('/worker/feedback/{tool}', function (Tool $tool) {
    $status = session('status');
    $expirationDate = session('expiration_date');

    return view('worker.feedback', compact('tool', 'status', 'expirationDate'));
})->name('worker.feedback');


