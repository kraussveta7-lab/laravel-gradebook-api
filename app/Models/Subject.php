<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['title','lecturer_name'];

    public function students()
    {
        return $this->belongToMany(Student::class,'grades')
        ->withPivot('score','exam_date','id')
        ->using(Student::class,);
    }
}
