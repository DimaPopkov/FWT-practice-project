<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Gate;

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
        $grades = Grade::with(['user', 'subject'])->paginate(10);
        $subjects = Subject::all();

        return view('grades.index', compact('grades', 'subjects'), $service->getJournalData());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $student = null)
    {
        $students = User::all(); 
        $subjects = Subject::all(); 

        return view('grades.create', compact('student', 'students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        $data = $request->validated();

        Grade::create($data);

        return redirect()->route('grades.index')->with('success', 'Оценка успешно добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student)
    {
        $student->load('grades.subject'); 
    
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade, User $student)
    {
        $subjects = Subject::all();

        return view('grades.edit', compact('grade', 'student', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, Grade $grade)
    {
        $student = $grade->user;

        Gate::authorize('manage-grades', $student);

        $grade->update($request->validated());
        
        return redirect()->route('grades.index')->with('success', 'Оценка изменена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $studentId = $grade->user_id;

        $grade->delete();
        
        return redirect()->route('grades.index')->with('success', 'Оценка успешно удалена!');
    }
}
