<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
     protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'indexx', 'short_description', 'long_description', 'description', 'read_more', 'photo'
    ];
}
