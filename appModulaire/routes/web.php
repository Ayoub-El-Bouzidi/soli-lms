<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Modules\Pkg_CahierText\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Formateur routes
Route::middleware(['auth:formateurs'])->group(function () {
    Route::get('/formateur/dashboard', [DashboardController::class, 'formateurDashboard'])->name('formateur.dashboard');
});

// Responsable routes
Route::middleware(['auth:responsables'])->group(function () {
    Route::get('/responsable/dashboard', [DashboardController::class, 'responsableDashboard'])->name('responsable.dashboard');
});
