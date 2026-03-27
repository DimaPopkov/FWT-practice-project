<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GradeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupStudentController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('groups', GroupController::class);// -> middleware('auth');

Route::get('groups/{group}/students', [GroupStudentController::class, 'index'])->name('groups.students.index');// -> middleware('auth');
Route::get('groups/{group}/students/create', [GroupStudentController::class, 'create'])->name('groups.students.create');// -> middleware('auth');
Route::post('groups/{group}/students', [GroupStudentController::class, 'store'])->name('groups.students.store');// -> middleware('auth');

Route::get('students/', [GroupStudentController::class, 'index'])->name('students.index');// -> middleware('auth');
Route::get('students/{student}', [GroupStudentController::class, 'show'])->name('students.show');// -> middleware('auth');
Route::get('students/{student}/edit', [GroupStudentController::class, 'edit'])->name('students.edit');// -> middleware('auth');
Route::put('students/{student}', [GroupStudentController::class, 'update'])->name('students.update');// -> middleware('auth');
Route::delete('students/{student}', [GroupStudentController::class, 'destroy'])->name('students.destroy');// -> middleware('auth');

Route::get('grades/', [GradeController::class, 'index'])->name('grades.index');// -> middleware('auth');
Route::get('students/{student}/grades/create', [GradeController::class, 'create'])->name('grades.create');// -> middleware('auth');
Route::post('students/{student}/grades', [GradeController::class, 'store'])->name('grades.store');// -> middleware('auth');
Route::get('grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');// -> middleware('auth');
Route::put('grades/{grade}', [GradeController::class, 'update'])->name('grades.update');// -> middleware('auth');
Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');// -> middleware('auth');

Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');;// -> middleware('auth');

Route::resource('subjects', SubjectController::class);// -> middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';