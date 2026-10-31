<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\KnowledgeDocumentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UnansweredQuestionController;
use Illuminate\Support\Facades\Route;

/*
| Admin area for the AI assistant: FAQs, knowledge documents, analytics.
| Uses the existing users table; only users with is_admin may enter.
*/

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:6,1')->name('login.store');

    Route::middleware('admin')->group(function (): void {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::post('/faqs/import', [FaqController::class, 'import'])->name('faqs.import');
        Route::resource('faqs', FaqController::class)->except('show');
        Route::resource('categories', FaqCategoryController::class)->only(['index', 'store', 'update', 'destroy'])
            ->parameters(['categories' => 'category']);
        Route::resource('documents', KnowledgeDocumentController::class)->except('show');

        Route::get('/unanswered', [UnansweredQuestionController::class, 'index'])->name('unanswered');
        Route::post('/unanswered/{message}/dismiss', [UnansweredQuestionController::class, 'dismiss'])->name('unanswered.dismiss');

        Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });
});
