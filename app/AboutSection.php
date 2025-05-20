<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
     protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'indexx', 'details', 'photo'
    ];
}
