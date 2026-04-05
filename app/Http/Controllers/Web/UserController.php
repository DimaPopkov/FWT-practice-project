<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Gate;

use App\Models\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Services\FileService;

class UserController extends Controller
{
    protected $fileService;
    
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    use AuthorizesRequests;

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
            $user->save();
        }

        return back()->with('status', 'profile-updated');
    }

    public function exportPdf(User $user)
    {
        Gate::authorize('exportPdf', $user);

        return $this->fileService->exportUserToPdf($user);
    }

    public function exportCv(User $user)
    {
        $this->authorize('view', $user);

        $fileName = 'cv_' . $user->id . '_' . time() . '.pdf';
        $path = 'public/cv/' . $fileName;

        $pdf = \PDF::loadView('pdf.cv', compact('user'));
        Storage::put($path, $pdf->output());

        return response()->json([
            'message' => 'CV успешно сгенерировано',
            'download_url' => asset(Storage::url($path))
        ]);
    }
}
