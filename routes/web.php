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

// Recovery routes
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('password.request');
Route::post('/recovery-login', [LoginController::class, 'recoveryLogin'])->name('recovery.login');
Route::post('/reset-password', [LoginController::class, 'resetWithSecurity'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('siswa.dashboard');
    Route::get('/siswa/history/konsultasi', [App\Http\Controllers\Siswa\DashboardController::class, 'historyKonsultasi'])->name('siswa.history.konsultasi');
    Route::get('/siswa/history/pelaporan', [App\Http\Controllers\Siswa\DashboardController::class, 'historyPelaporan'])->name('siswa.history.pelaporan');
    Route::post('/siswa/report/{report}/hide', [App\Http\Controllers\Siswa\DashboardController::class, 'hide'])->name('siswa.report.hide');

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
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store');
    
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students', function() { return 'Daftar Siswa'; })->name('students.index');
});

Route::prefix('gurubk')->name('gurubk.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\GuruBK\DashboardController::class, 'index'])->name('dashboard');
    Route::post('claim/{report}', [App\Http\Controllers\GuruBK\DashboardController::class, 'claim'])->name('report.take');
    Route::get('report/{report}', [App\Http\Controllers\GuruBK\DashboardController::class, 'show'])->name('report.show');
    Route::post('report/{report}/resolve', [App\Http\Controllers\GuruBK\DashboardController::class, 'resolve'])->name('report.resolve');
    
    Route::get('letters/create', [App\Http\Controllers\GuruBK\LetterController::class, 'create'])->name('letters.create');
    Route::post('letters', [App\Http\Controllers\GuruBK\LetterController::class, 'store'])->name('letters.store');
    
    Route::get('archives', [App\Http\Controllers\GuruBK\ArchiveController::class, 'index'])->name('archives.index');
    Route::get('archives/export', [App\Http\Controllers\GuruBK\ArchiveController::class, 'export'])->name('archives.export');
    Route::get('archives/{archive}', [App\Http\Controllers\GuruBK\ArchiveController::class, 'show'])->name('archives.show');

    Route::get('students', [App\Http\Controllers\GuruBK\StudentController::class, 'index'])->name('students.index');
    Route::get('students/create', [App\Http\Controllers\GuruBK\StudentController::class, 'create'])->name('students.create');
    Route::post('students', [App\Http\Controllers\GuruBK\StudentController::class, 'store'])->name('students.store');
    Route::get('students/{student}', [App\Http\Controllers\GuruBK\StudentController::class, 'show'])->name('students.show');
    Route::get('students/{student}/edit', [App\Http\Controllers\GuruBK\StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/{student}', [App\Http\Controllers\GuruBK\StudentController::class, 'update'])->name('students.update');
    Route::delete('students/{student}', [App\Http\Controllers\GuruBK\StudentController::class, 'destroy'])->name('students.destroy');
    
    // Counseling Sessions
    Route::resource('counseling', App\Http\Controllers\GuruBK\CounselingSessionController::class)->names('counseling');
});
