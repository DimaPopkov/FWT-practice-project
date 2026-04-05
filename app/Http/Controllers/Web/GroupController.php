<?php

namespace App\Http\Controllers\Web;

use App\Models\Group;
use App\Models\User;

use Illuminate\Http\Request;

use App\Services\UserService;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GroupController extends Controller
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
    public function index(Request $request)
    {
        $this->authorize('viewAny', Group::class);
        $groups = Group::search($request->name)
            ->paginate(10)
            ->withQueryString();

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Group::class);
        $group = new Group();
        return view('groups.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $this->authorize('create', Group::class);
        Group::create($request->validated());
        return redirect()->route('groups.index')->with('success', 'Группа успешно добавлена.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group, User $user)
    {
        $this->authorize('view', $group);
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $this->authorize('update', $group);   

        $currentStudents = $group->users()->where('role', 3)->get();

        $availableStudents = User::where('role', 3)
            ->whereNull('group_id')
            ->get();

        return view('groups.edit', compact('group', 'currentStudents', 'availableStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $this->authorize('update', $user);
        $group->update($request->validated());
        return redirect()->route('groups.index')->with('success', 'Группа успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->authorize('destroy', $user);
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Группа удалена.');
    }

    public function addUser(Request $request, Group $group)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        
        $user = User::findOrFail($request->user_id);
        $user->update(['group_id' => $group->id]);

        return back()->with('success', "Студент {$user->name} добавлен в группу.");
    }

    public function removeUser(Group $group, User $user)
    {
        $user->update(['group_id' => null]);

        return back()->with('success', "Студент {$user->name} исключен из группы.");
    }
}
