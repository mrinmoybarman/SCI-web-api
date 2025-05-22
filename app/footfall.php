<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footfall extends Model
{
    //
    protected $fillable = [
        'date', 'hospitalId', 'addedBy', 'patient', 'chemo', 'radiation', 'doctors', 'total_beds'
    ];

}
