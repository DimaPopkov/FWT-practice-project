<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class FileService
{
    public function uploadAvatar(UploadedFile $file, int $userId): string
    {
        $folder = "user_{$userId}";

        // Генерируем уникальное имя файла
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        // ПРИНУДИТЕЛЬНО указываем диск 'avatars' (из config/filesystems.php)
        $path = Storage::disk('avatars')->putFileAs($folder, $file, $fileName);
        if (!$path) {
            throw new \Exception("Не удалось сохранить файл на диск avatars");
        }

        return $path;
    }

    public function getAvatarUrl(?string $path, int $width = 150): string
    {
        if (!$path) return asset('images/default-avatar.png');

        $disk = Storage::disk('avatars');
        
        // Если файла нет на диске (теперь это public/avatars)
        if (!$disk->exists($path)) return asset('images/default-avatar.png');

        // ... логика ресайза (она остается прежней) ...

        return $disk->url($path); 
    }

    public function deleteUserFolder(int $userId): void
    {
        Storage::disk('avatars')->deleteDirectory("user_{$userId}");
    }

    public function exportUserToPdf(User $user)
    {
        $pdf = Pdf::loadView('pdf.student_info', compact('user'));
        
        return $pdf->download("student_{$user->id}.pdf");
    }
}