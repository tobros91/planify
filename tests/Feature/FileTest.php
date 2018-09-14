<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_change_profile_image()
    {
        // Given
        Storage::fake('fake-disk');

        $user = factory(User::class)->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        // When
        $this->actingAs($user);

        $response = $this->json('POST', '/data/settings/upload', [
            'fileable_id' => 1,
            'fileable_type' => 'App\User',
            'file' => $file,
        ]);

        // Then
        $response->assertStatus(201);

        $this->assertDatabaseHas('files', [
            'fileable_id' => 1,
            'fileable_type' => 'App\User',
            'original_basename' => 'avatar.jpg'
        ]);

        $data = $response->decodeResponseJson();

        Storage::disk('fake-disk')->assertExists($data['path']);
    }
}
