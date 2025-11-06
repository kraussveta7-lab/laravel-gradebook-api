<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;


class GradeController extends Controller
{
    /**
     * @OA\Get(
     * path="/students/{student}/grades",
     * tags={"Оценки"},
     * summary="Получить все оценки студента",
     * description="Возвращает отсортированный список оценок по ID студента, включая предмет (subject).",
     * @OA\Parameter(
     * name="student",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer"),
     * description="ID студента"
     * ),
     * @OA\Response(
     * response=200,
     * description="Успешный ответ",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/GradeResource"))
     * )
     * ),
     * @OA\Response(response=404, description="Студент не найден")
     * )
     */
    public function index(Student $student)
    {
        $grades = Grade::where("student_id", $student->id)
            ->with('subject')
            ->orderBy('exam_date','desc')
            ->get();

        return GradeResource::collection($grades);
    }

    /**
     * @OA\Post(
     * path="/students/{student}/grades",
     * tags={"Оценки"},
     * summary="Создать новую оценку для студента",
     * @OA\Parameter(
     * name="student",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer"),
     * description="ID студента"
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"subject_id", "score", "exam_date"},
     * @OA\Property(property="subject_id", type="integer", example=3),
     * @OA\Property(property="score", type="integer", example=5),
     * @OA\Property(property="exam_date", type="string", format="date", example="2025-11-20")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Оценка успешно создана",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/GradeResource")
     * )
     * ),
     * @OA\Response(response=404, description="Студент не найден")
     * )
     */
    public function store(StoreGradeRequest $request, Student $student)
    {
        $data = $request->validated(); 

        $grade = Grade::create([
            'student_id' => $student->id,
            'subject_id' => $data['subject_id'],
            'score' => $data['score'],
            'exam_date' => $data['exam_date'],
        ]);
        
        $grade->load('subject');

        return GradeResource::make($grade)->response()->setStatusCode(201);
    }

    /**
     * @OA\Put(
     * path="/students/{student}/grades/{grade}",
     * tags={"Оценки"},
     * summary="Обновить оценку",
     * @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer"), description="ID студента (для проверки принадлежности)"),
     * @OA\Parameter(name="grade", in="path", required=true, @OA\Schema(type="integer"), description="ID оценки"),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"subject_id", "score", "exam_date"},
     * @OA\Property(property="subject_id", type="integer", example=3),
     * @OA\Property(property="score", type="integer", example=4),
     * @OA\Property(property="exam_date", type="string", format="date", example="2025-11-20")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Оценка успешно обновлена",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/GradeResource")
     * )
     * ),
     * @OA\Response(response=403, description="Оценка не принадлежит указанному студенту"),
     * @OA\Response(response=404, description="Студент или Оценка не найдены")
     * )
     */
    public function update(StoreGradeRequest $request, Student $student, Grade $grade) 
    {
        $data = $request->validated();
        
        if ($grade->student_id !== $student->id) {
            return response()->json(['message' => 'Оценка не принадлежит этому студенту'], 403);
        }

        $grade->update([
            'subject_id' => $data['subject_id'],
            'score' => $data['score'],
            'exam_date' => $data['exam_date'],
        ]);
        
        $grade->load('subject');

        return GradeResource::make($grade);
    }

    /**
     * @OA\Delete(
     * path="/students/{student}/grades/{grade}",
     * tags={"Оценки"},
     * summary="Удалить оценку",
     * @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer"), description="ID студента (для проверки принадлежности)"),
     * @OA\Parameter(name="grade", in="path", required=true, @OA\Schema(type="integer"), description="ID оценки"),
     * @OA\Response(
     * response=204,
     * description="Оценка успешно удалена"
     * ),
     * @OA\Response(response=403, description="Оценка не принадлежит указанному студенту"),
     * @OA\Response(response=404, description="Студент или Оценка не найдены")
     * )
     */
    public function destroy(Student $student, Grade $grade)
    {
        if ($grade->student_id !== $student->id) {
            
            return response()->json(['message' => 'Ошибочка, оценка не принадлежит этому студентуу'], 403);
        }
        
        $grade->delete(); 
        
        return response()->noContent();
    }
}