<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_User extends Model
{
    protected $table = 'student_users';
    protected $fillable = ['studentID', 'userID'];
}
