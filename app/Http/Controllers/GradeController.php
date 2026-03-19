<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;

use App\Http\Requests\GradeRequest;

use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['user', 'subject'])->paginate(10);

        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $student)
    {
        $subjects = Subject::all(); 
        return view('grades.create', compact('student', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request, User $student)
    {
        $student->grades()->create($request->validated());

        return redirect()->route('students.show', $student);
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
    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());
        return redirect()->route('students.show', $grade->user_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studentId = $grade->user_id;

        $grade->delete();
        
        return redirect()->route('students.show', $studentId);
    }
}
