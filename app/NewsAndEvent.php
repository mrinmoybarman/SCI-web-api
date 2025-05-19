<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsEventPhoto;

class NewsAndEvent extends Model
{
    protected $fillable = [
        'hospitalId', 'addedBy', 'name', 'details', 'indexx', 'status'
    ];

    public function photos()
    {
        return $this->hasMany(NewsEventPhoto::class, 'news_event_id');
    }
}
