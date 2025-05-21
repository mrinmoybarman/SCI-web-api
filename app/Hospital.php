<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name', 'aname', 'location', 'phone', 'phone2', 'email', 'whatsapp', 'address', 'gmap', 'level', 'facebook', 'instagram','twitter','linkedin', 'logo_primary', 'logo_secondary', 'intro_heading', 'intro', 'about_bg' 
    ];
}
