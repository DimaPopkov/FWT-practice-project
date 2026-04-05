<?php

namespace App\Http\Controllers\Web;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\UserService;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupStudentRequest;
use App\Http\Requests\UpdateGroupStudentRequest;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GroupStudentController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Group $group, Request $request, User $user)
    {
        $this->authorize('viewAny', $group);

        $currentUser = auth()->user();

        $query = User::filter($request->only(['name', 'birthday']))->with('group');

        if ($currentUser && $this->userService->is_admin($currentUser)) {
            $query->withTrashed();
        }

        $students = $query->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        $this->authorize('create', $group);
        return view('students.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupStudentRequest $request, Group $group)
    {
        $this->authorize('create', $group);
        $data = $request->validated();

        $group->users()->create($data); 

        return redirect()->route('groups.students.index', $group);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student)
    {
        $this->authorize('view', $student);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {
        $this->authorize('update', $student);

        $groups = Group::all();

        return view('students.edit', compact('student', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupStudentRequest $request, User $student)
    {
        $this->authorize('update', $student);

        $student->update($request->validated());

        return redirect()->route('students.show', $student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $this->authorize('destroy', $student);
        $student->delete();
        return back();
    }

    public function restore(User $student)
    {
        $this->authorize('restore', $student);
        $student->restore();
        return back();
    }

    public function forceDelete(User $student)
    {
        $this->authorize('forceDelete', $student);
        $student->forceDelete();
        return back();
    }
}
