<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class SpamTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_detects_spam()
    {
        $spam = new \App\Spam();
        
        $this->assertFalse($spam->detect('Innocent Reply Here'));
        $this->expectException(\Exception::class);
        $this->assertTrue($spam->detect('Yahoo customer service'));
    }
}
