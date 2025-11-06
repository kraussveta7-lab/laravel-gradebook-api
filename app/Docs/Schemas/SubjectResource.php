<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 * schema="SubjectResource",
 * title="Subject Resource (Output)",
 * description="Предмет, возвращаемый API, включая связанные оценки и студентов.",
 * @OA\Property(property="id", type="integer", example=3),
 * @OA\Property(property="title", type="string", description="Название предмета", example="Высшая математика"),
 * @OA\Property(property="lecturer_name", type="string", description="Имя лектора", example="Иванов И.И."),
 * @OA\Property(
 * property="grades",
 * type="array",
 * description="Список оценок по этому предмету (включая студента)",
 * @OA\Items(
 * @OA\Property(property="id", type="integer", example=5),
 * @OA\Property(property="score", type="integer", example=5),
 * @OA\Property(property="exam_date", type="string", format="date", example="2025-11-20"),
 * @OA\Property(property="student_id", type="integer", example=1) 
 * )
 * ),
 * @OA\Property(
 * property="students",
 * type="array",
 * description="Список студентов, получивших оценки по этому предмету (из hasManyThrough).",
 * @OA\Items(
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="first_name", type="string", example="Иван"),
 * @OA\Property(property="last_name", type="string", example="Иванов")
 * )
 * )
 * )
 */
class SubjectResource {}