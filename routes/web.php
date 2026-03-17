<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('group', GroupController::class)->names([
    'index' => 'group.index',
    'create' => 'group.create',
    'store' => 'group.store',
    'show' => 'group.show',
    'edit' => 'group.edit',
    'update' => 'group.update',
    'destroy' => 'group.destroy',
]) -> middleware('auth');

Route::get('group/{group}/students', [GroupStudentController::class, 'index'])->name('group.students.index');
Route::get('group/{group}/students/create', [GroupStudentController::class, 'create'])->name('group.students.create');
Route::post('group/{group}/students', [GroupStudentController::class, 'store'])->name('group.students.store');

Route::get('students/{student}', [GroupStudentController::class, 'show'])->name('students.show');
Route::get('students/{student}/edit', [GroupStudentController::class, 'edit'])->name('students.edit');
Route::put('students/{student}', [GroupStudentController::class, 'update'])->name('students.update');
Route::delete('students/{student}', [GroupStudentController::class, 'destroy'])->name('students.destroy');

Route::resource('subject', SubjectController::class)->names([
    'index' => 'subject.index',
    'create' => 'subject.create',
    'store' => 'subject.store',
    'show' => 'subject.show',
    'edit' => 'subject.edit',
    'update' => 'subject.update',
    'destroy' => 'subject.destroy',
]) -> middleware('auth');