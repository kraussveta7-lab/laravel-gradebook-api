<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;

class GradeController extends Controller
{
    public function index(Student $student)
    {
        return response()->json($student->subjects()->get());
    }

    public function store(StoreGradeRequest $request, Student $student)
    {
        $data = $request->validated(); 

    
    $student->subjects()->attach($data['subject_id'], [
        'score' => $data['score'],
        'exam_date' => $data['exam_date'],
    ]);

    
    $grade = Grade::where('student_id', $student->id)
                  ->where('subject_id', $data['subject_id'])
                  ->latest()
                  ->first();

    return response()->json($grade, 201);
    }

    public function update(StoreGradeRequest $request, Student $student, Grade $grade) 
{
    $data = $request->validated();
    
    
    // $studentId = $grade->student_id; 
    
    
    // $student = \App\Models\Student::findOrFail($studentId);

   
    $student->subjects()->updateExistingPivot($data['subject_id'], [
        'score' => $data['score'],
        'exam_date' => $data['exam_date'],
    ]);

    
    $grade->refresh();
    return response()->json($grade);
}

    public function destroy(Student $student, Grade $grade)
    {
        $subjectId = $grade->subject_id;
        $student->subjects()->detach($subjectId);

        return response()->noContent();
    }
}
