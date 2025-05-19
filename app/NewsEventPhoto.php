<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsAndEvent;

class NewsEventPhoto extends Model
{
    protected $fillable = ['news_event_id', 'photo_path'];

    public function newsEvent()
    {
        return $this->belongsTo(NewsAndEvent::class, 'news_event_id');
    }
}
