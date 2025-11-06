<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
     * @OA\Get(
     * path="/students",
     * tags={"Студенты"},
     * summary="Получить список всех студентов",
     * @OA\Response(
     * response=200,
     * description="Успешный ответ. Возвращает коллекцию студентов.",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/StudentResource"))
     * )
     * )
     * )
     */
    public function index()
    {
        $students = Student::with(['grades.subject', 'subjects'])->get();
        return StudentResource::collection($students);
    }

    /**
     * @OA\Post(
     * path="/students",
     * tags={"Студенты"},
     * summary="Создать нового студента",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"first_name", "last_name", "student_id_number"},
     * @OA\Property(property="first_name", type="string", example="Сергей"),
     * @OA\Property(property="last_name", type="string", example="Петров"),
     * @OA\Property(property="student_id_number", type="string", example="S1002")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Студент успешно создан",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/StudentResource")
     * )
     * )
     * )
     */
    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());

        $student->load(['grades.subject', 'subjects']);

        return StudentResource::make($student)->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     * path="/students/{student}",
     * tags={"Студенты"},
     * summary="Получить данные студента по ID",
     * description="Включает в себя Eager Loading связей grades и subjects.",
     * @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer"), description="ID студента"),
     * @OA\Response(
     * response=200,
     * description="Успешный ответ",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/StudentResource")
     * )
     * ),
     * @OA\Response(response=404, description="Студент не найден")
     * )
     */
    public function show(Student $student)
    {
        $student->load(['grades.subject','subjects']);

        return StudentResource::make($student);
    }

    /**
     * @OA\Put(
     * path="/students/{student}",
     * tags={"Студенты"},
     * summary="Обновить данные студента",
     * @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer"), description="ID студента"),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"first_name", "last_name", "student_id_number"},
     * @OA\Property(property="first_name", type="string", example="Сергей (Обновлено)"),
     * @OA\Property(property="last_name", type="string", example="Петров"),
     * @OA\Property(property="student_id_number", type="string", example="S1002")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Успешное обновление",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/StudentResource")
     * )
     * ),
     * @OA\Response(response=404, description="Студент не найден")
     * )
     */
    public function update(StoreStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        
        $student->load(['grades.subject','subjects']);

        return StudentResource::make($student);
    }

    /**
     * @OA\Delete(
     * path="/students/{student}",
     * tags={"Студенты"},
     * summary="Удалить студента",
     * @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer"), description="ID студента"),
     * @OA\Response(
     * response=204,
     * description="Студент успешно удален (Нет содержимого)"
     * ),
     * @OA\Response(response=404, description="Студент не найден")
     * )
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->noContent();
    }
}
