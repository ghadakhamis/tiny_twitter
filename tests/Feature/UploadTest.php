<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessUploadImage()
    {
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->post(route('upload.image'), [
            'file' => $file,
        ]);

        $response->assertStatus(200);
    }

    public function testFaildUploadImage()
    {
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->post(route('upload.image'));

        $response->assertStatus(400);
    }
}
