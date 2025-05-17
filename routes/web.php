<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('bugs', BugController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

//admins pow
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index'); // Changed from 'users' to 'users.index'
    Route::put('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role.update');
    
    // Put specific routes before generic ones
    Route::get('/bugs/unassigned', [AdminController::class, 'unassignedBugs'])->name('bugs.unassigned');
    Route::post('/bugs/{bug}/assign', [AdminController::class, 'assignBug'])->name('bugs.assign')->where('bug', '[0-9]+');
    Route::get('/bugs', [AdminController::class, 'bugs'])->name('bugs');
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles.index');
    Route::post('/roles', [AdminController::class, 'storeRole'])->name('roles.store');
});


require __DIR__.'/auth.php';require __DIR__.'/auth.php';

