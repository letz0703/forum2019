<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdminTest extends TestCase{
    
    use RefreshDatabase;
    
    /** @test */
    public function an_administrator_can_access_the_administration_section()
    {
        $this->signInAdmin();
        $this->get('/admin')
             ->assertStatus(Response::HTTP_OK);
    }
    
    /** @test */
    public function non_administrator_cannot_access_the_administration_section()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $this->get('/admin')
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
    
    /** @test */
    public function a_channel_requires_a_name()
    {
        $this->withExceptionHandling();
        
        $this->signInAdmin();
        $this->createChannel(['name' => null])
             -> assertSessionHasErrors('name');
    }
    
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
        
        return $this->post('/admin/channels', $channel->toArray());
    }
    
    
}
