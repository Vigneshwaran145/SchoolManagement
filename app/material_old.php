<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class material extends Model
{
    //
    protected $fillable = ['teacherID', 'file', 'extension'];
}
