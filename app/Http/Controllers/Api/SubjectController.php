<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use Illuminate\Http\Request;
use App\Models\Subject; 
use App\Http\Resources\SubjectResource;


class SubjectController extends Controller
{
    /**
     * @OA\Get(
     * path="/subjects",
     * tags={"Предметы"},
     * summary="Получить список всех предметов",
     * @OA\Response(
     * response=200,
     * description="Успешный ответ. Возвращает коллекцию предметов с их связями.",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/SubjectResource"))
     * )
     * )
     * )
     */
    public function index()
    {
        $subjects = Subject::with(['grades.student', "students"])->get();
        return SubjectResource::collection($subjects);
    }

    /**
     * @OA\Post(
     * path="/subjects",
     * tags={"Предметы"},
     * summary="Создать новый предмет",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"title", "lecturer_name"},
     * @OA\Property(property="title", type="string", example="История"),
     * @OA\Property(property="lecturer_name", type="string", example="Петров П.П.")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Предмет успешно создан",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/SubjectResource")
     * )
     * )
     * )
     */
    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        $subject->load(['grades.student',"students"]);
        return SubjectResource::make($subject)->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     * path="/subjects/{subject}",
     * tags={"Предметы"},
     * summary="Получить предмет по ID",
     * description="Включает в себя Eager Loading связей grades и students.",
     * @OA\Parameter(name="subject", in="path", required=true, @OA\Schema(type="integer"), description="ID предмета"),
     * @OA\Response(
     * response=200,
     * description="Успешный ответ",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/SubjectResource")
     * )
     * ),
     * @OA\Response(response=404, description="Предмет не найден")
     * )
     */
    public function show(Subject $subject)
    {
        $subject->load(['grades.student','students']);

        return SubjectResource::make($subject);
    }

    /**
     * @OA\Put(
     * path="/subjects/{subject}",
     * tags={"Предметы"},
     * summary="Обновить данные предмета",
     * @OA\Parameter(name="subject", in="path", required=true, @OA\Schema(type="integer"), description="ID предмета"),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"title", "lecturer_name"},
     * @OA\Property(property="title", type="string", example="История (Обновлено)"),
     * @OA\Property(property="lecturer_name", type="string", example="Петров П.П.")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Успешное обновление",
     * @OA\JsonContent(
     * @OA\Property(property="data", ref="#/components/schemas/SubjectResource")
     * )
     * ),
     * @OA\Response(response=404, description="Предмет не найден")
     * )
     */
    public function update(StoreSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        $subject->load(['grades.student','students']);

        return SubjectResource::make($subject);
    }

    /**
     * @OA\Delete(
     * path="/subjects/{subject}",
     * tags={"Предметы"},
     * summary="Удалить предмет",
     * @OA\Parameter(name="subject", in="path", required=true, @OA\Schema(type="integer"), description="ID предмета"),
     * @OA\Response(
     * response=204,
     * description="Предмет успешно удален (Нет содержимого)"
     * ),
     * @OA\Response(response=404, description="Предмет не найден")
     * )
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->noContent();
    }
}