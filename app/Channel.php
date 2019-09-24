<?php

namespace App;

use const false;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];
    protected $casts = [
        'archived' => 'boolean',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('active', function ($builder){
            $builder->where('archived', false)
                    ->orderBy('name', 'asc');
        });
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function threads()
    {
        return $this->hasMany('App\Thread');
    }
    
    function make_slug($string)
    {
        $slug = preg_replace('/\s+/u', '-', trim($string));
        return $slug = str_slug($slug);
    }
    
    public function archive()
    {
        $this->update([
            'archived' => true,
        ]);
    }
    
}
