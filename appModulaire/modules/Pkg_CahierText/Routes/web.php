<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Pkg_CahierText\App\Exports\ModulesExport;
use Modules\Pkg_CahierText\Controllers\DashboardController;
use Modules\Pkg_CahierText\Controllers\ModuleController;
use Modules\Pkg_CahierText\Controllers\CahierEntryController;

// Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Routes pour les modules
Route::resource('modules', ModuleController::class);

// Routes pour le cahier de texte
Route::prefix('cahier-de-texte')->middleware(['web', 'auth.multiguard:formateurs,responsables'])->group(function () {
    Route::get('/', [CahierEntryController::class, 'index'])->name('cahier-de-texte.index');
    Route::get('/create', [CahierEntryController::class, 'create'])->name('cahier-de-texte.create');
    Route::post('/', [CahierEntryController::class, 'store'])->name('cahier-de-texte.store');
    Route::post('/from-seance-emploi', [CahierEntryController::class, 'createFromSeanceEmploi'])->name('cahier-de-texte.from-seance-emploi');
    Route::get('/{entry}/edit', [CahierEntryController::class, 'edit'])->name('cahier-de-texte.edit');
    Route::put('/{entry}', [CahierEntryController::class, 'update'])->name('cahier-de-texte.update');
    Route::delete('/{entry}', [CahierEntryController::class, 'destroy'])->name('cahier-de-texte.destroy');
});

// Export modules
Route::get('/exportModules', [ModuleController::class, 'export'])->name('modules.export');
// Export cahier entries
Route::get('/exportCahierEntries', [CahierEntryController::class, 'export'])->name('cahier-de-texte.export');
