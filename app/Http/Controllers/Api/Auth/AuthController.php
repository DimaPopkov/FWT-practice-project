<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/login',
        summary: 'Авторизация пользователя',
        tags: ['Auth'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@test.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password')
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Успешный вход',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'token', type: 'string')
            ]
        )
    )]
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            return response()->json([
                'access_token' => $token,
                'user' => new UserResource($user)
            ]);
        }

        return response()->json(['error' => 'Вы не авторизованы'], 401);
    }

    #[OA\Post(
        path: '/logout',
        summary: 'Выход из аккаунта',
        tags: ['Auth'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\Response(
        response: 200,
        description: 'Успешный выход',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Вы успешно вышли из аккаунта')
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Вы не авторизованы'
    )]
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Вы успешно вышли из аккаунта']);
    }

    #[OA\Post(
        path: '/reset-password',
        summary: 'Смена пароля авторизованного пользователя',
        tags: ['Auth'],
        security: [['bearerAuth' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'password', type: 'string', minLength: 8, example: 'new_secret_password'),
                new OA\Property(property: 'password_confirmation', type: 'string', example: 'new_secret_password')
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Пароль успешно изменен',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Пароль успешно обновлён')
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: 'Ошибка валидации'
    )]
    #[OA\Response(
        response: 401,
        description: 'Пользователь не авторизован'
    )]
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Пароль успешно обновлён']);
    }
}
