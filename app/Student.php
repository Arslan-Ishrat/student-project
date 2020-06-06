<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['classroomId', 'name', 'fatherName', 'age'];
}
