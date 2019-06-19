<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    
    use Favoritable, RecordActivity ;
    
    protected $guarded = [];
    protected $with = ['owner','favorites'];
    protected $appends = ['favoritesCount'];
    
    //
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }
    
    public function path(){
        return $this->thread->path()."#reply-{$this->id}";
    }
    
    
}
