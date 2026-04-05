<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Subject;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Subject $subject)
    {
        $this->authorize('viewAny', $subject);
        $subjects = Subject::search($request->name)
            ->paginate(10)
            ->withQueryString();

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject)
    {
        $this->authorize('create', $subject);
        $subject = new Subject();
        return view('subjects.create', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request, Subject $subject)
    {
        $this->authorize('store', $subject);
        Subject::create($request->validated());
        return redirect()->route('subjects.index')->with('success', 'Предмет успешно добавлен.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $this->authorize('update', $subject);
        $subject->update($request->validated());
        return redirect()->route('subjects.index')->with('success', 'Предмет успешно обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('destroy', $subject);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Предмет удален.');
    }
}
