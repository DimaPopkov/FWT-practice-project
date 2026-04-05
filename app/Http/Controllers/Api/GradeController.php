<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Grade;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Resources\GradeResource;

use OpenApi\Attributes as OA;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/users/{user}/grades',
        summary: 'Получить список оценок пользователя',
        tags: ['Grades'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'user',
        in: 'path',
        required: true,
        description: 'ID пользователя (студента)',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Список оценок успешно получен',
        content: new OA\JsonContent(type: 'array', items: new OA\Items(type: 'object'))
    )]
    #[OA\Response(response: 401, description: 'Не авторизован')]
    public function index(User $user)
    {
        return GradeResource::collection($user->grades);
    }

    /**
     * Store a newly created resource in storage.
     */
     #[OA\Post(
        path: '/users/{user}/grades',
        summary: 'Поставить оценку пользователю',
        tags: ['Grades'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'user',
        in: 'path',
        required: true,
        description: 'ID студента, которому ставим оценку',
        schema: new OA\Schema(type: 'integer', example: 1)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['grade'],
            properties: [
                new OA\Property(property: 'grade', type: 'integer', description: 'Оценка (1-5)', minimum: 1, maximum: 5, example: 5)
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Оценка успешно добавлена',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Оценка успешно добавлена'),
                new OA\Property(property: 'data', type: 'object')
            ]
        )
    )]
    #[OA\Response(response: 403, description: 'Недостаточно прав для выставления оценки этому студенту')]
    #[OA\Response(response: 422, description: 'Ошибка валидации данных')]
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'grade'      => 'required|integer|min:1|max:5',
        ]);

        if (!Gate::allows('manage-grades', $user)) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        $grade = Grade::create([
            'user'       => $user->id,
            'subject_id' => $validated['subject_id'],
            'grade'      => $validated['grade'],
        ]);

        return response()->json([
            'message' => 'Оценка успешно добавлена',
            'data' => $grade
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
