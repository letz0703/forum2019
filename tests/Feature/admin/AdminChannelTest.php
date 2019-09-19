<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_channel_requires_a_name()
    {
        $this->withExceptionHandling();
        $this->signInAdmin();

        $channel = make('App\Channel', ['name' => null]);
        $this->post(route('admin.channels.store'), $channel->toArray())
             ->assertSessionHasErrors('name');
    }

    /** @test */
    public function an_administrator_can_access_the_administration_section()
    {
        //$administrator = factory('App\User')->create();
        //config(['forum.administrators' => [$administrator->email]]);
        $this->signInAdmin();
        $this->get(route('admin.dashboard.index'))
             ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function non_administrator_cannot_access_the_administration_section()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $this->get(route('admin.dashboard.index'))
             ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function admin_can_create_a_channel()
    {
        //$this->withExceptionHandling();
        $this->signInAdmin();
        $channel = make('App\Channel', [
            'name'        => 'php',
            'description' => 'This is php channel',
        ]);
        $response = $this->post('/admin/channels', $channel->toArray());

        $this->get($response->headers->get('Location'))
             ->assertSee('php')
             ->assertSee('This is php channel');
    }
}
