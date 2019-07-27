<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialClassMap extends Model
{
    protected $fillable = ['materialID', 'classID','studentID'];
}
