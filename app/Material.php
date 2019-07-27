<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['subjectID', 'file', 'extension', 'fileName', 'teacherID'];
    protected $primaryKey = 'materialID';
}
