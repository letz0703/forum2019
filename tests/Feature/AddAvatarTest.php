<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_members_can_add_avatar()
    {
        $this->withExceptionHandling();
        $this->json('POST', '/api/users/1/avatar')->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $this->withExceptionHandling()->signIn();
        $this->json('POST', '/api/users/'.auth()->id().'/avatar', [
            'avatar' => 'not-an-image',
        ])->assertStatus(422);
    }

    /** @test */
    public function users_can_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('POST', '/api/users/'.auth()->id().'/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals(asset('avatars/'.$file->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/'.$file->hashName());
    }

    /** @test */
    public function a_user_can_determin_their_avatar_path()
    {
        $user = create('App\User');
        $this->assertEquals(asset('avatars/default.jpg'), $user->avatar_path);
        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals(asset('avatars/me.jpg'), $user->avatar_path);
    }
}
