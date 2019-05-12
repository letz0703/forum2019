<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

/**
 * Class ThreadFilters
 * @package App\Filters
 */
class ThreadFilters
{
    
    /**
     * @var Request
     */
    protected $request;
    protected $builder;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function apply($builder)
    {
        $this->builder = $builder;
        
        if ($this->request->has('by')){
            return $this->by($this->request->by);
        }
        
        return $builder;
    }
    
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
    
}