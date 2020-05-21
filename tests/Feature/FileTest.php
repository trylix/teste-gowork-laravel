<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_will_upload_file()
    {
        $response = $this->apiAs('POST', 'upload', [
            'file' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'path',
        ]);
    }
}
