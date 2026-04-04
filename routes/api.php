<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GradeController;

use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset-password', [AuthController::class, 'logout']);
    
    Route::apiResource('/groups', GroupController::class);
    Route::apiResource('/subjects', SubjectController::class);

    Route::get('/users', [UserController::class, 'index']); // Список всех пользователей
    Route::get('/groups/{group}/users', [UserController::class, 'groupUsers']); // Юзеры группы
    Route::get('/users/{user}/cv', [UserController::class, 'exportCv']); // Ссылка на CV

    Route::get('/users/{user}/grades', [GradeController::class, 'index']); // Получить оценки
    Route::post('/users/{user}/grades', [GradeController::class, 'store']); // Поставить оценку
});