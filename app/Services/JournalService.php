<?php

namespace App\Services;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Group;

class JournalService
{
    public function getJournalData($groupId = null)
    {
        $users = User::with('grades.subject')->paginate(10);
        $subjects = Subject::all();
        $groups = Group::all();

        // [user_id => [subject_id => grade]]
        $gradesMap = $users->getCollection()->mapWithKeys(function ($user) {
            return [$user->id => $user->grades->pluck('grade', 'subject_id')];
        });

        $bestStudents = $users->getCollection()->filter->isExcellentStudent();
        $goodStudents = $users->getCollection()->filter->isGoodStudent();

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