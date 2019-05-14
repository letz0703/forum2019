<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    
    protected $filters = [];
    
    /**
     * @var Request
     */
    protected $request, $builder;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function apply($builder)
    {
        $this->builder = $builder;
        //foreach ($this->filters as $filter){
        foreach ($this->getFilters() as $filter => $value){
            if (method_exists($this, $filter)){
                $this->$filter($this->request->$filter);
            } //if ( ! $this->hasFilter($filter)) return;
        }
        
        //if ($this->request->has('by')){
        //    return $this->by($this->request->by);
        //}
        
        return $this->builder;
    }
    
    /**
     * @return array
     */
    protected function getFilters(): array
    {
        return $this->request->only($this->filters);
    }
}