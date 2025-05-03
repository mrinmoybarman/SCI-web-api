<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'designation', 'depertment', 'qualification', 'achievement', 'awards'
    ];
}
