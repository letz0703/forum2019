<?php

namespace App;

trait Favoritable{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model){
            $model->favorites->each->delete();
        });
    }
    
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        
        if ( ! $this->favorites()->where($attributes)->exists()){
            Reputation::award(auth()->user(), Reputation::REPLY_IS_FAVORITED);
            
            return $this->favorites()->create($attributes);
        }
    }
    
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        Reputation::swipe(auth()->user(), Reputation::REPLY_IS_FAVORITED);
        
        $this->favorites()->get()->each->delete();
        //$this->favorites()->where($attributes)->get()->each(function($favorite){
        //    $favorite->delete();
        //});
        //$this->favorites()->where($attributes)->delete();
    }
    
    public function isFavorited()
    {
        //return $this->favorites()->where(['user_id' => auth()->id()])->exists();
        return (bool) $this->favorites->where('user_id', auth()->id())->count();
    }
    
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
