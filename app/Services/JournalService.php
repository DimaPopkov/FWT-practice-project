<?php

namespace App\Services;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Group;

use App\Services\UserService;

class JournalService
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getJournalData($groupId = null)
    {
        $users = User::with('grades.subject')->paginate(10);
        $subjects = Subject::all();
        $groups = Group::all();

        // [user_id => [subject_id => grade]]
        $gradesMap = $users->getCollection()->mapWithKeys(function ($user) {
            return [$user->id => $user->grades->pluck('grade', 'subject_id')];
        });

        // $bestStudents = $users->getCollection()->filter->isExcellentStudent();
        $bestStudents = $users->getCollection()->filter(function ($user) {
            return $this->userService->isExcellentStudent($user);
        });
        // $goodStudents = $users->getCollection()->filter->isGoodStudent();
        $goodStudents = $users->getCollection()->filter(function ($user) {
            return $this->userService->isGoodStudent($user);
        });

        $groupsStats = Group::with('users.grades')->get()->mapWithKeys(function ($group) {
            $statsBySubject = $group->users->flatMap->grades
                ->groupBy('subject_id')
                ->map(fn($grades) => round($grades->avg('grade'), 2));

            return [$group->id => $statsBySubject];
        });

        return compact(
            'users', 'subjects', 'groups', 
            'gradesMap', 'bestStudents', 'goodStudents', 
            'groupsStats'
        );
    }
}