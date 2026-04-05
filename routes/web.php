<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\GradeController;
use App\Http\Controllers\Web\GroupController;
use App\Http\Controllers\Web\GroupStudentController;
use App\Http\Controllers\Web\JournalController;
use App\Http\Controllers\Web\SubjectController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\UserController;


Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
Route::resource('groups', GroupController::class);
Route::resource('subjects', SubjectController::class);

Route::post('groups/{group}/add-user', [GroupController::class, 'addUser'])->name('groups.add-user');
Route::delete('groups/{group}/remove-user/{user}', [GroupController::class, 'removeUser'])->name('groups.remove-user');
Route::get('groups/{group}/students', [GroupStudentController::class, 'index'])->name('groups.students.index');
Route::get('groups/{group}/students/create', [GroupStudentController::class, 'create'])->name('groups.students.create');
Route::post('groups/{group}/students', [GroupStudentController::class, 'store'])->name('groups.students.store');

Route::get('students/', [GroupStudentController::class, 'index'])->name('students.index');
Route::get('students/{student}', [GroupStudentController::class, 'show'])->name('students.show');
Route::get('students/{student}/edit', [GroupStudentController::class, 'edit'])->name('students.edit');
Route::put('students/{student}', [GroupStudentController::class, 'update'])->name('students.update');
Route::delete('students/delete/{student}', [GroupStudentController::class, 'destroy'])->name('students.destroy');

Route::get('grades/', [GradeController::class, 'index'])->name('grades.index');
Route::get('students/grades/create', [GradeController::class, 'create'])->name('grades.create');
Route::post('students/grades/store', [GradeController::class, 'store'])->name('grades.store');
Route::get('grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
Route::put('grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');

Route::get('/users/{user}/export-pdf', [UserController::class, 'exportPdf'])->name('users.export_pdf');
Route::post('/users/{user}/avatar', [UserController::class, 'updateAvatar'])->name('users.update_avatar');

Route::post('users/{student}/restore', [GroupStudentController::class, 'restore'])->name('students.restore')
    ->withTrashed();

Route::delete('users/{student}/force-delete', [GroupStudentController::class, 'forceDelete'])->name('students.force_delete')
    ->withTrashed();

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::redirect('/', '/register');

require __DIR__.'/auth.php';