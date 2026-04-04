<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Grade;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        return GradeResource::collection($user->grades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade'      => 'required|integer|min:1|max:5',
        ]);

        $student = User::findOrFail($validated['student_id']);

        if (!Gate::allows('manage-grades', $student)) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        $grade = Grade::create($validated);

        return response()->json([
            'message' => 'Оценка успешно добавлена',
            'data' => $grade
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
