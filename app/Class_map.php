<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Class_map extends Model
{
    protected $fillable=['standardID', 'sectionID'];
    protected $primaryKey = 'classID';
}
