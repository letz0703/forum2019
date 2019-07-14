<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class SpamTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    //public function it_detects_spam()
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();
        
        $this->assertFalse($spam->detect('Innocent Reply Here'));
        $this->expectException(\Exception::class);
        $this->assertTrue($spam->detect('Yahoo customer service'));
    }
    
    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();
        $this->expectException('Exception');
        $spam->detect('aaaaaaa');
    }
    
}
