<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsAndEvent extends Model
{
    protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'photo', 'details', 'indexx'
    ];
}
