<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'registerPost'])->name('register.post')->middleware('throttle:3,1');

Route::post('/login', [LoginController::class, 'manualLogin'])->name('login.post')->middleware('throttle:5,1');
Route::post('/guest-login', [RegisterController::class, 'guestLogin'])->name('guest.login')->middleware('throttle:10,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Recovery routes
Route::get('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.request');
Route::post('/recovery-login', [PasswordController::class, 'recoveryLogin'])->name('recovery.login')->middleware('throttle:5,1');
Route::post('/reset-password', [PasswordController::class, 'resetWithSecurity'])->name('password.update')->middleware('throttle:5,1');

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

    // Profile & settings routes
    Route::get('/settings', [PasswordController::class, 'showSettings'])->name('profile.settings');
    Route::post('/settings/password', [PasswordController::class, 'updatePassword'])->name('profile.password.update');
});

use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students', function() { return redirect()->route('admin.dashboard'); })->name('students.index');
});

Route::prefix('gurubk')->name('gurubk.')->middleware(['auth', 'role:guru_bk'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\GuruBK\DashboardController::class, 'index'])->name('dashboard');
    Route::post('claim/{report}', [App\Http\Controllers\GuruBK\DashboardController::class, 'claim'])->name('report.take');
    Route::get('report/{report}', [App\Http\Controllers\GuruBK\DashboardController::class, 'show'])->name('report.show');
    Route::post('report/{report}/resolve', [App\Http\Controllers\GuruBK\DashboardController::class, 'resolve'])->name('report.resolve');
    
    Route::get('documents', [App\Http\Controllers\GuruBK\DocumentController::class, 'index'])->name('documents.index');

    Route::get('letters/create', [App\Http\Controllers\GuruBK\LetterController::class, 'create'])->name('letters.create');
    Route::post('letters', [App\Http\Controllers\GuruBK\LetterController::class, 'store'])->name('letters.store');
    Route::get('letters/skorsing/create', [App\Http\Controllers\GuruBK\LetterController::class, 'createSkorsing'])->name('letters.skorsing.create');
    Route::post('letters/skorsing', [App\Http\Controllers\GuruBK\LetterController::class, 'storeSkorsing'])->name('letters.skorsing.store');
    Route::get('letters/sp1/create', [App\Http\Controllers\GuruBK\LetterController::class, 'createSp1'])->name('letters.sp1.create');
    Route::post('letters/sp1', [App\Http\Controllers\GuruBK\LetterController::class, 'storeSp1'])->name('letters.sp1.store');
    Route::get('letters/sp2/create', [App\Http\Controllers\GuruBK\LetterController::class, 'createSp2'])->name('letters.sp2.create');
    Route::post('letters/sp2', [App\Http\Controllers\GuruBK\LetterController::class, 'storeSp2'])->name('letters.sp2.store');
    
    Route::get('archives', [App\Http\Controllers\GuruBK\ArchiveController::class, 'index'])->name('archives.index');
    Route::get('archives/export', [App\Http\Controllers\GuruBK\ArchiveController::class, 'export'])->name('archives.export');
    Route::get('archives/{archive}', [App\Http\Controllers\GuruBK\ArchiveController::class, 'show'])->name('archives.show');

    Route::get('anecdotes/export', [App\Http\Controllers\GuruBK\AnecdoteController::class, 'export'])->name('anecdotes.export');

    Route::get('students', [App\Http\Controllers\GuruBK\StudentController::class, 'index'])->name('students.index');
    Route::get('students/create', [App\Http\Controllers\GuruBK\StudentController::class, 'create'])->name('students.create');
    Route::post('students', [App\Http\Controllers\GuruBK\StudentController::class, 'store'])->name('students.store');
    Route::get('students/{student}', [App\Http\Controllers\GuruBK\StudentController::class, 'show'])->name('students.show');
    Route::get('students/{student}/edit', [App\Http\Controllers\GuruBK\StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/{student}', [App\Http\Controllers\GuruBK\StudentController::class, 'update'])->name('students.update');
    Route::delete('students/bulk-destroy', [App\Http\Controllers\GuruBK\StudentController::class, 'bulkDestroy'])->name('students.bulk_destroy');
    Route::delete('students/{student}', [App\Http\Controllers\GuruBK\StudentController::class, 'destroy'])->name('students.destroy');
    
    // Counseling Sessions
    Route::resource('counseling', App\Http\Controllers\GuruBK\CounselingSessionController::class)->names('counseling');
});
