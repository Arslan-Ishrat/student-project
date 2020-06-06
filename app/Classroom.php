<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['standard'];

    public function students(){
        return $this->hasMany(Student::class, 'classroomId');
    }
}
