<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'photo', 'short_description', 'long_description', 'description', 'read_more', 'read_more2', 'indexx'
    ];
}
