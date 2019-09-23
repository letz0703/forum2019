<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];
    protected $casts = [
        'archived' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany('App\Thread');
    }

    public function make_slug($string)
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
