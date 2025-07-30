<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DownloadController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/portfolio', [ProjectController::class, 'publicPortfolio'])->name('portfolio');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/download/resume', [DownloadController::class, 'downloadResume'])->name('download.resume');
Route::get('/download/cv', [DownloadController::class, 'downloadCV'])->name('download.cv');
Route::get('/download/info', [DownloadController::class, 'getFileInfo'])->name('download.info');
Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');

Route::middleware(['auth'])->group(function () {
    Route::get('/upload', [UploadController::class, 'create'])->name('upload');
    Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function () {
        Route::get('/blog', [App\Http\Controllers\Admin\BlogPostController::class, 'index'])->name('blog.index');
        Route::get('/blog/create', [App\Http\Controllers\Admin\BlogPostController::class, 'create'])->name('blog.create');
        Route::post('/blog', [App\Http\Controllers\Admin\BlogPostController::class, 'store'])->name('blog.store');
        Route::get('/blog/{blog}/edit', [App\Http\Controllers\Admin\BlogPostController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{blog}', [App\Http\Controllers\Admin\BlogPostController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{blog}', [App\Http\Controllers\Admin\BlogPostController::class, 'destroy'])->name('blog.destroy');

        // Admin Projects CRUD for AJAX editing
        Route::get('/projects/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'show'])->name('projects.show');
        Route::put('/projects/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('projects.destroy');
    });
});
