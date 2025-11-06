<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 * schema="StudentResource",
 * title="Student Resource (Output)",
 * description="Студент, возвращаемый API, включая оценки и предметы.",
 * @OA\Property(property="id", type="integer", description="ID студента", example=1),
 * @OA\Property(property="first_name", type="string", description="Имя", example="Иван"),
 * @OA\Property(property="last_name", type="string", description="Фамилия", example="Иванов"),
 * @OA\Property(property="student_id_number", type="string", description="Номер зачетной книжки / ID", example="S1001"),
 * @OA\Property(
 * property="grades",
 * type="array",
 * description="Список оценок студента",
 * @OA\Items(ref="#/components/schemas/GradeResource") 
 * ),
 * @OA\Property(
 * property="subjects",
 * type="array",
 * description="Список уникальных предметов, по которым есть оценки (из hasManyThrough)",
 * @OA\Items(
 * @OA\Property(property="id", type="integer", example=3),
 * @OA\Property(property="title", type="string", example="Высшая математика")
 * )
 * )
 * )
 */
class StudentResource {}