<?php

namespace App\Services;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Group;

class UserService
{
    public static function getRoles(): array
    {
        return [
            User::ROLE_ADMIN => 'Администратор',
            User::ROLE_TEACHER => 'Учитель',
            User::ROLE_STUDENT => 'Студент',
        ];
    }

    public function checkRole(User $user, int $roleId): bool
    {
        return (int)$user->role === $roleId;
    }

    public function is_admin(User $user): bool
    {
        return (int)$user->role === USER::ROLE_ADMIN;
    }

    public function is_teacher(User $user): bool
    {
        return (int)$user->role === USER::ROLE_TEACHER;
    }

    public function is_student(User $user): bool
    {
        return (int)$user->role === USER::ROLE_STUDENT;
    }

    public function getGradeClassAttribute(User $user): string
    {
        if ($this->isExcellentStudent($user)) {
            return 'table-success';
        }

        if ($this->isGoodStudent($user)) {
            return 'table-warning';
        }

        return 'table-danger'; // striped
    }

    public function isExcellentStudent(User $user): bool
    {
        return $user->grades->isNotEmpty() 
            && $user->grades->every('grade', 5);
    }

    public function isGoodStudent(User $user): bool
    {
        return $user->grades->isNotEmpty() 
            && $user->grades->every('grade', '>=', 4) 
            && $user->grades->avg('grade') < 5;
    }
}