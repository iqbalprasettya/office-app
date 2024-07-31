<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatsController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    // dashboard
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/create', [DashboardController::class, 'create'])->name('create');
        Route::post('/store', [DashboardController::class, 'store'])->name('store');
        Route::get('/edit/{user}', [DashboardController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [DashboardController::class, 'update'])->name('update');
        Route::delete('/destroy/{user}', [DashboardController::class, 'destroy'])->name('destroy');

        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');

        // report
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::get('/report/create', [ReportController::class, 'create'])->name('createReport');
        Route::post('/report/store', [ReportController::class, 'store'])->name('storeReport');

        Route::get('/report/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/report/{id}', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

        Route::post('/reports/display', [ReportController::class, 'display'])->name('reports.display');
        Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

        // chats
        Route::get('/chats', [ChatsController::class, 'index'])->name('chats');
        Route::get('/chats/{recipientId}', [ChatsController::class, 'fetchMessages'])->name('chats.fetch');
        Route::post('/chats/{recipientId}', [ChatsController::class, 'send'])->name('chats.send');

        Route::get('/chats/start/{recipientId}', [ChatsController::class, 'startChat'])->name('chats.start');
    });
});
