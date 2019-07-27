<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_teacher extends Model
{
    protected $table = 'teacher_users';
    protected $fillable = ['user_id', 'teacher_id'];
}
