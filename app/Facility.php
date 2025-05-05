<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'photo', 'details', 'indexx'
    ];
}
