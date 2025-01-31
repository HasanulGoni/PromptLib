<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PromptController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('prompts/savedPrompt', [UserDashboardController::class, 'savedPrompt'])->name('prompts.savedPrompt');
Route::get('prompts/reportedPrompt', [UserDashboardController::class, 'reportedPrompt'])->name('prompts.reportedPrompt');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('prompts/search', [PromptController::class, 'search'])->name('prompts.search');


    Route::get('prompts/{prompt}', [UserDashboardController::class, 'show'])->name('prompts.show');
    // Save Prompt
    // Route::get('prompts/savedPrompttt', function ()  {
    //     return "Sdfsdfsd";
    // });
    
    // Route::get('prompts/savedPrompt', [UserDashboardController::class, 'savedPrompt'])->name('prompts.savedPrompt');
    
    Route::post('prompts/{prompt}/save', [UserDashboardController::class, 'savePrompt'])->name('prompts.save');
    Route::post('prompts/{prompt}/remove', [UserDashboardController::class, 'removePrompt'])->name('prompts.remove');

    // Report Prompt

    Route::post('prompts/{prompt}/report', [UserDashboardController::class, 'reportPrompt'])->name('prompts.report');

    // Review Prompt
    Route::post('prompts/{prompt}/review', [ReviewController::class, 'store'])->name('prompts.review');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

});

Route::middleware(['auth', Admin::class])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('/users', AdminUserController::class);
    Route::resource('/categories', AdminCategoryController::class);
    Route::resource('/tags', AdminTagController::class);
    Route::resource('/prompts', PromptController::class);
    Route::get('prompts/upload/create', [PromptController::class, 'uploadCSVcreateForm'])->name('prompts.upload.create');
    Route::post('prompts/upload', [PromptController::class, 'uploadCSV'])->name('prompts.upload');



});

require __DIR__.'/auth.php';
