<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreGroupRequest;

use App\Models\Group;

use App\Http\Resources\GroupResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use OpenApi\Attributes as OA;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/groups',
        summary: 'Получить список групп',
        tags: ['Groups'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        required: false,
        description: 'Поиск по названию группы',
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
    #[OA\Response(response: 401, description: 'Не авторизован')]
    #[OA\Response(response: 403, description: 'Нет прав на просмотр групп')]
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Group::class);

        $groups = Group::search($request->name)->paginate(10);

        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/groups',
        summary: 'Создать новую группу',
        tags: ['Groups'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', description: 'Название группы', example: 'П-41')
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Группа успешно создана',
        content: new OA\JsonContent(type: 'object')
    )]
    #[OA\Response(response: 401, description: 'Не авторизован')]
    #[OA\Response(response: 403, description: 'Нет прав на создание группы')]
    #[OA\Response(response: 422, description: 'Ошибка валидации')]
    public function store(StoreGroupRequest $request, Group $group)
    {
        $this->authorize('create', $group);

        $group = Group::create($request->validated());

        return (new GroupResource($group))->response()->setStatusCode(201);
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
