<?php


use Illuminate\Support\Facades\Route;
use Modules\Pkg_CahierText\Controllers\DashboardController;

Route::get('/dash', [DashboardController::class, 'index'])->name('dashboard');

