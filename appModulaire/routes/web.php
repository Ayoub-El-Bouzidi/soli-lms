<?php

use Illuminate\Support\Facades\Route;
use Modules\Pkg_CahierText\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

// Temporary debug route
Route::get('/debug-permissions', function () {
    $guard = session('auth.guard', 'web');
    $user = Auth::guard($guard)->user();

    if ($user) {
        $permissions = [];
        $roles = [];

        // Check if user has HasRoles trait
        if (method_exists($user, 'getAllPermissions')) {
            $permissions = $user->getAllPermissions()->pluck('name')->toArray();
        }
        if (method_exists($user, 'getRoleNames')) {
            $roles = $user->getRoleNames()->toArray();
        }

        // Check specific permissions
        $canCreateModules = $user->can('create_modules');
        $canEditModules = $user->can('edit_modules');

        // If it's a multi-guard user, check the User model too
        $userModel = null;
        $userModelPermissions = [];
        $userModelRoles = [];
        $userModelCanCreate = false;
        $userModelCanEdit = false;

        if ($guard === 'formateurs' || $guard === 'responsables') {
            $userModel = \App\Models\User::find($user->user_id ?? $user->id);
            if ($userModel) {
                if (method_exists($userModel, 'getAllPermissions')) {
                    $userModelPermissions = $userModel->getAllPermissions()->pluck('name')->toArray();
                }
                if (method_exists($userModel, 'getRoleNames')) {
                    $userModelRoles = $userModel->getRoleNames()->toArray();
                }
                $userModelCanCreate = $userModel->can('create_modules');
                $userModelCanEdit = $userModel->can('edit_modules');
            }
        }

        return response()->json([
            'guard' => $guard,
            'user_id' => $user->id,
            'user_name' => $user->name ?? $user->nom ?? 'Unknown',
            'user_permissions' => $permissions,
            'user_roles' => $roles,
            'user_can_create_modules' => $canCreateModules,
            'user_can_edit_modules' => $canEditModules,
            'user_model' => $userModel ? [
                'id' => $userModel->id,
                'name' => $userModel->name,
                'permissions' => $userModelPermissions,
                'roles' => $userModelRoles,
                'can_create_modules' => $userModelCanCreate,
                'can_edit_modules' => $userModelCanEdit,
            ] : null,
        ]);
    }

    return response()->json(['error' => 'No user authenticated']);
})->middleware('auth:web,formateurs,responsables');

Route::middleware(['auth:web,formateurs,responsables'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Formateur routes
Route::middleware(['auth:formateurs'])->group(function () {
    Route::get('/formateur/dashboard', [DashboardController::class, 'formateurDashboard'])->name('formateur.dashboard');
});

// Responsable routes
Route::middleware(['auth:responsables'])->group(function () {
    Route::get('/responsable/dashboard', [DashboardController::class, 'responsableDashboard'])->name('responsable.dashboard');
});
