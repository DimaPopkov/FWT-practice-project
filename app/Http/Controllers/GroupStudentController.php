<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\StoreGroupStudentRequest;
use App\Http\Requests\UpdateGroupStudentRequest;

class GroupStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Group $group, Request $request)
    {
        $students = User::filter($request->only(['name', 'birthday']))->with('group')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        return view('students.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupStudentRequest $request, Group $group)
    {
        $data = $request->validated();

        $group->users()->create($data); 

        return redirect()->route('groups.students.index', $group);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupStudentRequest $request, User $student)
    {
        $student->update($request->validated());
        return redirect()->route('students.show', $student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $student->delete();
        return back();
    }
}
