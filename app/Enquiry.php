<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'hospitalId', 'name', 'email', 'mobile', 'message'
    ];
}
