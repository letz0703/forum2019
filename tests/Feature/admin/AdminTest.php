<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_channel_requires_a_description()
    {
        $this->withExceptionHandling();

        $this->createChannel(['description' => null])
             ->assertSessionHasErrors('description');
    }

    protected function createChannel($overrides = [])
    {
        $this->signInAdmin();
        $channel = make('App\Channel', $overrides);

        return $this->post(route('admin.channels.store'), $channel->toArray());
    }
}
