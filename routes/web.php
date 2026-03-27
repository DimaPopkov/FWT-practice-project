<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GradeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupStudentController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\SubjectController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('groups', GroupController::class);
// -> middleware('auth');

Route::get('groups/{group}/students', [GroupStudentController::class, 'index'])->name('groups.students.index');
Route::get('groups/{group}/students/create', [GroupStudentController::class, 'create'])->name('groups.students.create');
Route::post('groups/{group}/students', [GroupStudentController::class, 'store'])->name('groups.students.store');

Route::get('students/', [GroupStudentController::class, 'index'])->name('students.index');
Route::get('students/{student}', [GroupStudentController::class, 'show'])->name('students.show');
Route::get('students/{student}/edit', [GroupStudentController::class, 'edit'])->name('students.edit');
Route::put('students/{student}', [GroupStudentController::class, 'update'])->name('students.update');
Route::delete('students/{student}', [GroupStudentController::class, 'destroy'])->name('students.destroy');

Route::get('grades/', [GradeController::class, 'index'])->name('grades.index');
Route::get('students/{student}/grades/create', [GradeController::class, 'create'])->name('grades.create');
Route::post('students/{student}/grades', [GradeController::class, 'store'])->name('grades.store');
Route::get('grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
Route::put('grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');

Route::get('/journal', [JournalController::class, 'index']);

Route::resource('subjects', SubjectController::class);
// -> middleware('auth');