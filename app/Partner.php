<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'hospitalId', 'name', 'addedBy', 'photo', 'indexx'
    ];
}
