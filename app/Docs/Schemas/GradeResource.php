<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 * schema="GradeResource",
 * title="Grade Resource (Output)",
 * description="Оценка, возвращаемая API, включая связанный предмет",
 * @OA\Property(property="id", type="integer", example=5),
 * @OA\Property(property="student_id", type="integer", example=1),
 * @OA\Property(property="score", type="integer", example=5),
 * @OA\Property(property="exam_date", type="string", format="date", example="2025-11-20"),
 * @OA\Property(
 * property="subject",
 * type="object",
 * description="Связанный предмет",
 * @OA\Property(property="id", type="integer", example=3),
 * @OA\Property(property="title", type="string", example="Высшая математика"),
 * @OA\Property(property="lecturer_name", type="string", example="Петров")
 * ) 
 * ) 
 */
class GradeResource {}