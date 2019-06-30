<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters
{
    
    /**
     * @var array
     */
    protected $filters = ['by', 'popular','unaswered'];
    
    /**
     * @param $username
     *
     * @return mixed
     */
    
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        
        return $this->builder->where('user_id', $user->id);
    }
    
    
    /**
     * Filter the thread according to most popular threads
     * @return $this
     */
    protected function popular()
    {
        //$this->builder->getQuery()->oders = []; // not working
        return $this->builder->orderBy('replies_count', 'desc');
    }
    
    protected function unaswered()
    {
        //$this->builder->getQuery()->oders = []; // not working
        return $this->builder->where('replies_count',0);
    }
    
}