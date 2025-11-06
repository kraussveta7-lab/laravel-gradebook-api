<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\OpenApi(
 * @OA\Info(
 * version="1.0.0",
 * title="Система оценок (Gradebook API)",
 * description="API для управления студентами, предметами и их оценками. Использованы Laravel Resources и hasManyThrough.",
 * @OA\Contact(
 * email="artemtaiti@gmail.com"
 * )
 * ),
 * @OA\Server(
 * description="Laravel API Server",
 * url="http://127.0.0.1:8000/api"
 * )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}