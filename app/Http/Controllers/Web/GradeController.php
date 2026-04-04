<?php

namespace App\Http\Controllers\Web;


use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;

use App\Services\JournalService;
use App\Services\UserService;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GradeController extends Controller
{
    use AuthorizesRequests;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(JournalService $service, User $student)
    { 
        $this->authorize('viewAny', $student);
        $grades = Grade::with(['user', 'subject'])->paginate(10);
        $subjects = Subject::all();

        return view('grades.index', compact('grades', 'subjects'), $service->getJournalData());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $student)
    {
        $this->authorize('create', $student);
        $subjects = Subject::all(); 
        return view('grades.create', compact('student', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request, User $student)
    {
        $this->authorize('store', $student);
        $student->grades()->create($request->validated());

        return redirect()->route('students.show', $student);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student)
    {
        $this->authorize('show', $student);
        $student->load('grades.subject'); 
    
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade, User $student)
    {
        $this->authorize('edit', $student);
        return view('grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, Grade $grade, User $user)
    {
        $student = $grade->user;
        Gate::authorize('manage-grades', $student);

        $this->authorize('update', $user);

        $grade->update($request->validated());
        return redirect()->route('students.show', $grade->user_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, User $student)
    {
        $this->authorize('destroy', $student);
        $studentId = $grade->user_id;

        $grade->delete();
        
        return redirect()->route('students.show', $studentId);
    }
}
