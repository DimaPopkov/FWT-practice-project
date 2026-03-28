<?php

namespace App\Listeners;

use App\Models\Subject;
use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignInitialGrades
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            $event->user->grades()->create([
                'subject_id' => $subject->id,
                'grade' => rand(2, 5),
            ]);
        }
    }
}
