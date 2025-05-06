<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slides extends Model
{
    protected $fillable = [
        'hospitalId', 'addedBy', 'photo', 'indexx'
    ];
}
