<?php


use Illuminate\Support\Facades\Route;
use Modules\Pkg_CahierText\Controllers\DashboardController;
use Modules\Pkg_CahierText\Controllers\ModuleController;

// Route pour le tableau de bord
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Groupe de routes pour les modules
Route::prefix('modules')->name('modules.')->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('index');
    // Route::get('/{id}', [ModuleController::class, 'show'])->name('show'); // si tu veux afficher les détails
});

