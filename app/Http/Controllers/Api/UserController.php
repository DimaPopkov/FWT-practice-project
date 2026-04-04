<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Return all users
     */
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    /**
     * Return all users in manage group
     */
    public function groupUsers(Group $group)
    {
        return UserResource::collection($group->users);
    }

    /**
     * Generate CV to user (../public/cv/cv_user_{id}.pdf)
     */
    public function exportCv(User $user)
    {
        $fileName = 'cv_user_' . $user->id . '.pdf';
        $directory = 'public/cv';
        $path = 'cv/' . $fileName;

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $pdf = Pdf::loadView('pdf.student_info', ['user' => $user]);

        Storage::disk('public')->put($path, $pdf->output());

        return response()->json([
            'message' => 'CV успешно сгенерирован',
            'url' => asset('storage/' . $path)
        ]);
    }
}
