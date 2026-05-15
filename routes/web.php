<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerPost'])->name('register.post');

Route::post('/login', [LoginController::class, 'manualLogin'])->name('login.post');
Route::post('/guest-login', [LoginController::class, 'guestLogin'])->name('guest.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('siswa.dashboard');

    Route::get('/form', [ReportController::class, 'create'])->name('lapor.create');
    Route::post('/form', [ReportController::class, 'store'])->name('lapor.store');
    Route::get('/form/success', [ReportController::class, 'success'])->name('lapor.success');

    // Chat routes
    Route::get('/chat/{report}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{report}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{report}/poll', [ChatController::class, 'poll'])->name('chat.poll');
});

use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\GuruBK\DashboardController;
use App\Http\Controllers\GuruBK\LetterController;
use App\Http\Controllers\GuruBK\ArchiveController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store');
    
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students', function() { return 'Daftar Siswa'; })->name('students.index');
});

Route::prefix('gurubk')->name('gurubk.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('claim/{report}', [DashboardController::class, 'claim'])->name('claim');
    Route::get('report/{report}', [DashboardController::class, 'show'])->name('report.show');
    Route::post('report/{report}/resolve', [DashboardController::class, 'resolve'])->name('report.resolve');
    
    Route::get('letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('letters', [LetterController::class, 'store'])->name('letters.store');
    
    Route::get('archives', [ArchiveController::class, 'index'])->name('archives.index');

    Route::get('students', [App\Http\Controllers\GuruBK\StudentController::class, 'index'])->name('students.index');
    Route::post('students', [App\Http\Controllers\GuruBK\StudentController::class, 'store'])->name('students.store');
});
