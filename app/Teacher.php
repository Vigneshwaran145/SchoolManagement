<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['teacherName', 'qualification', 'dob', 'address', 'teacher_mail'];
    protected $primaryKey = 'teacherID';
}
