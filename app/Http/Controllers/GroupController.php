<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        $group = new Group();
        return view('groups.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        Group::create($request->validated());
        return redirect()->route('groups.index')->with('success', 'Группа успешно добавлена.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->update($request->validated());
        return redirect()->route('groups.index')->with('success', 'Группа успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Группа удалена.');
    }
}
