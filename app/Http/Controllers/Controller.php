<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Student API Documentation",
    version: "1.0.0",
    description: "Документация для API"
)]
#[OA\Server(
    url: "/api",
    description: "Основной API сервер"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
abstract class Controller
{
    //
}
