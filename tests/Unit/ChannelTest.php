<?php

namespace Tests\Unit;

use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_channel_consists_of_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channel->id]);
        
        $this->assertTrue($channel->threads->contains($thread));
    }
    
    /** @test */
    public function a_channel_can_be_archived()
    {
        $channel = create('App\Channel');
        $this->assertFalse($channel->archived);
        $channel->archive();
        $this->assertTrue($channel->fresh()->archived);
    }
    
    /** @test */
    public function archived_channels_are_excluded_by_default()
    {
        create('App\Channel');
        create('App\Channel', ['archived' => true]);
        
        $this->assertEquals(1, Channel::count());
    }
    
    /** @test */
    public function users_may_not_see_archived_channels()
    {
        $this->signInAdmin();
        $channel1 = create('App\Channel', ['name' => 'aaa']);
        $channel2 = create('App\Channel', ['name' => 'foo']);
        $archivedChannel = create('App\Channel',
            ['name' => 'ccc', 'archived' => true]);
        
        $response = $this->getJson(route('api.channels.index'))
                         ->assertDontSee($archivedChannel['name'])
                         ->assertSee($channel1['name']);
        $data = $response->json();
        
        //dd($data[0]['name']);
        $this->assertEquals($data[0]['name'], $channel1->name);
    }
    
}
