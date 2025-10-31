<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;
use App\Models\Subject;

class Student extends Model
{   
    protected $fillable = ["first_name","last_name","student_id_number"];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, "grades")->withPivot("score","exam_date","id")
        ->using(Grade::class);
        
    }

}
