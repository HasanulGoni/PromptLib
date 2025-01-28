<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PromptController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Middleware\Admin;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('prompts/search', [PromptController::class, 'search'])->name('prompts.search');
});

Route::middleware(['auth', Admin::class])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('/users', AdminUserController::class);
    Route::resource('/categories', AdminCategoryController::class);
    Route::resource('/prompts', PromptController::class);
    Route::get('prompts/upload/create', [PromptController::class, 'uploadCSVcreateForm'])->name('prompts.upload.create');
    Route::post('prompts/upload', [PromptController::class, 'uploadCSV'])->name('prompts.upload');

});

require __DIR__.'/auth.php';
