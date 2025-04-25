<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name', 'aname', 'location', 'phone', 'email', 'whatsapp', 'address', 'gmap', 'level', 'facebook', 'instagram','twitter','linkedin', 'logo-primary', 'logo-secondary' 
    ];
}
