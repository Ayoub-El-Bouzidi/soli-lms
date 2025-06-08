<?php

use Illuminate\Support\Facades\Route;
use Modules\Pkg_CahierText\Controllers\DashboardController;
use Modules\Pkg_CahierText\Controllers\ModuleController;
use Modules\Pkg_CahierText\Controllers\CahierEntryController;

Route::middleware(['web'])->group(function () {
    // Route pour le tableau de bord
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les modules
    Route::resource('modules', ModuleController::class);

    // Routes pour le cahier de texte
    Route::prefix('cahier-de-texte')->group(function () {
        Route::get('/', [CahierEntryController::class, 'index'])->name('cahier.index');
        Route::get('/create', [CahierEntryController::class, 'create'])->name('cahier.create');
        Route::post('/', [CahierEntryController::class, 'store'])->name('cahier.store');
        Route::get('/{entry}/edit', [CahierEntryController::class, 'edit'])->name('cahier.edit');
        Route::put('/{entry}', [CahierEntryController::class, 'update'])->name('cahier.update');
        Route::delete('/{entry}', [CahierEntryController::class, 'destroy'])->name('cahier.destroy');
    });
});
