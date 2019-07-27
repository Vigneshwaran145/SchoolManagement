<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['studentName', 'classID', 'dob', 'studentCode', 'stud_mail'];
    protected $primaryKey = 'studentID';
}
