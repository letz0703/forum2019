<?php
/**
 * Created by letz.
 * User: letz
 * Date: 07/08/2019
 * Time: 4:09 AM
 */

namespace App;


use Illuminate\Support\Facades\Redis;

trait RecordVisit
{
    
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());
        return $this;
    }
    public function visits()
    {
        return Redis::get($this->visitsCacheKey())?? 0;
    }
    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());
        return $this;
    }
    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}