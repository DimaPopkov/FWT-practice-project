<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Group;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

use OpenApi\Attributes as OA;

class UserController extends Controller
{
    /**
     * Return all users
     */
    #[OA\Get(
        path: '/users',
        summary: 'Получить список всех пользователей',
        tags: ['Users'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'Успешно',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                new OA\Property(property: 'links', type: 'object'),
                new OA\Property(property: 'meta', type: 'object')
            ]
        )
    )]
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    /**
     * Return all users in manage group
     */
    #[OA\Get(
        path: '/groups/{group}/users',
        summary: 'Получить всех пользователей конкретной группы',
        tags: ['Users'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'group',
        in: 'path',
        required: true,
        description: 'ID группы',
        schema: new OA\Schema(type: 'integer', example: 1)
    )]
    #[OA\Response(
        response: 200,
        description: 'Список пользователей группы',
        content: new OA\JsonContent(type: 'array', items: new OA\Items(type: 'object'))
    )]
    #[OA\Response(response: 404, description: 'Группа не найдена')]
    public function groupUsers(Group $group)
    {
        return UserResource::collection($group->users);
    }

    /**
     * Generate CV to user (../public/cv/cv_user_{id}.pdf)
     */
    #[OA\Get(
        path: '/users/{user}/cv',
        summary: 'Генерирование CV пользователя в формате PDF',
        tags: ['Users'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'user',
        in: 'path',
        required: true,
        description: 'ID пользователя для генерации CV',
        schema: new OA\Schema(type: 'integer', example: 1)
    )]
    #[OA\Response(
        response: 200,
        description: 'PDF успешно сгенерирован',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'CV успешно сгенерирован'),
                new OA\Property(property: 'url', type: 'string', example: 'http://127.0.0.0:8000/storage/cv/cv_user_1.pdf')
            ]
        )
    )]
    #[OA\Response(response: 404, description: 'Пользователь не найден')]
    public function exportCv(User $user)
    {
        $fileName = 'cv_user_' . $user->id . '.pdf';
        $relativeFolder = 'cv/user_' . $user->id;

        $directory = public_path($relativeFolder);

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $path = $directory . '/' . $fileName;

        $pdf = Pdf::loadView('pdf.student_info', ['user' => $user]);

        $pdf->save($path);

        return response()->json([
            'message' => 'CV успешно сгенерирован',
            'url' => asset($relativeFolder . '/' . $fileName)
        ]);
    }
}
