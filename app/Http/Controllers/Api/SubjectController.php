<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Subject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Resources\SubjectResource;

use OpenApi\Attributes as OA;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/subjects',
        summary: 'Получить список предметов',
        tags: ['Subjects'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        required: false,
        description: 'Поиск по названию предмета',
        schema: new OA\Schema(type: 'string')
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
    #[OA\Response(response: 403, description: 'Нет прав на просмотр')]
    public function index(Request $request, Subject $subject)
    {
        Gate::authorize('viewAny', $subject);

        $subjects = Subject::search($request->name);

        return SubjectResource::collection($subjects->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/subjects',
        summary: 'Создать новый предмет',
        tags: ['Subjects'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', description: 'Название предмета', example: 'Математика')
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Предмет успешно создан',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Предмет успешно добавлен'),
                new OA\Property(property: 'data', type: 'object')
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Ошибка валидации')]
    public function store(StoreSubjectRequest $request)
    {
        $this->authorize('store', $subject);

        $subject = Subject::create($request->validated());

        return response()->json([
            'message' => 'Предмет успешно добавлен',
            'data' => new SubjectResource($subject)
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
