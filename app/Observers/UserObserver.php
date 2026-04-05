<?php

namespace App\Observers;

use App\Models\User;

use App\Services\FileService;

use Illuminate\Support\Facades\Storage;

class UserObserver
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    // public function updating(User $user): void
    // {
    //     // Проверяем: изменилось ли поле avatar И было ли там старое значение
    //     if ($user->isDirty('avatar') && $user->getOriginal('avatar')) {
    //         // Удаляем старую папку со всеми ресайзами перед записью новой
    //         $this->fileService->deleteUserFolder($user->id);
    //     }
    // }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->deleteUserAvatars($user->id);
    }

    protected function deleteUserAvatars(int $userId): void
    {
        $directory = "user_{$userId}";
        
        if (Storage::disk('avatars')->exists($directory)) {
            Storage::disk('avatars')->deleteDirectory($directory);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
