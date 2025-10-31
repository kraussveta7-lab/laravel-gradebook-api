<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use Illuminate\Http\Request;
use App\Models\Subject; 
use App\Http\Requests\SubjectRequest;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Subject::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return response()->json($subject,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->noContent();
    }
}
