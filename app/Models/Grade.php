<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Grade extends Pivot
{
    protected $table = "grades";

    protected $fillable = ['srudent_id','subject_id','score','exam_date'];

    protected $casts = [
        'exam_date'=>'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
