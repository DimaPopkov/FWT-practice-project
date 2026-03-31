<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

use App\Models\User;

use Illuminate\Http\Request;

use App\Services\FileService;

class UserController extends Controller
{
    protected $fileService;
    
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }


    public function export(User $user, FileService $fileService)
    {
        $this->authorize('exportPdf', $user);
        return $fileService->exportUserToPdf($user);
    }

    public function updateAvatar(Request $request, User $user)
    {
        if ($request->hasFile('avatar')) {
            $path = $this->fileService->uploadAvatar($request->file('avatar'), $user->id);
            
            $user->avatar = $path;
            $user->save(); // Observer сам удалит старое, если настроен
        }

        return back()->with('status', 'profile-updated');
    }

    public function exportPdf(User $user)
    {
        Gate::authorize('exportPdf', $user);

        return $this->fileService->exportUserToPdf($user);
    }
}
