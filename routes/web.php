<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\EmailTrackingController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Professors Routes
Route::prefix('professors')->group(function () {
    // Route::get('/', [ProfessorController::class, 'index'])->name('professors.index');
    // Route::get('/create', [ProfessorController::class, 'create'])->name('professors.create');
    // Route::post('/', [ProfessorController::class, 'store'])->name('professors.store');
    // Route::get('/{professor}/edit', [ProfessorController::class, 'edit'])->name('professors.edit');
    // Route::put('/{professor}', [ProfessorController::class, 'update'])->name('professors.update');
    // Route::delete('/{professor}', [ProfessorController::class, 'destroy'])->name('professors.destroy');

    // Excel Import
    Route::post('/import', [ProfessorController::class, 'import'])->name('professors.import');
    Route::get('/export', [ProfessorController::class, 'export'])->name('professors.export');
});

// Email Templates Routes
Route::prefix('templates')->group(function () {
    Route::get('/', [EmailTemplateController::class, 'index'])->name('templates.index');
    Route::get('/create', [EmailTemplateController::class, 'create'])->name('templates.create');
    Route::post('/', [EmailTemplateController::class, 'store'])->name('templates.store');
    Route::get('/{template}/edit', [EmailTemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/{template}', [EmailTemplateController::class, 'update'])->name('templates.update');
    Route::delete('/{template}', [EmailTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::get('/{template}/preview', [EmailTemplateController::class, 'preview'])->name('templates.preview');
});

Route::prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/create', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('/', [SettingsController::class, 'store'])->name('settings.store');
});

// Email Campaigns Routes
Route::prefix('campaigns')->group(function () {
    Route::get('/', [EmailCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/create', [EmailCampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/', [EmailCampaignController::class, 'startCampaign'])->name('campaigns.store');
    Route::get('/{campaign}', [EmailCampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/{campaign}/edit', [EmailCampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/{campaign}', [EmailCampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/{campaign}', [EmailCampaignController::class, 'destroy'])->name('campaigns.destroy');
});

// Email Tracking Route
Route::get('/track/{tracking_id}', [EmailTrackingController::class, 'track'])
    ->name('email.track');

// Fallback Route
Route::fallback(function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->name('home');
