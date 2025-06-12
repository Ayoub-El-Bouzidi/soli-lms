<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Modules\Pkg_CahierText\Controllers\DashboardController;
Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
