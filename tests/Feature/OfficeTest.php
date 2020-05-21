<?php

namespace Tests\Feature;

use App\Office;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OfficeTest extends TestCase
{
    use DatabaseMigrations;

    protected $officeId;

    public function setUp(): void
    {
        parent::setUp();

        User::create([
            'name' => 'Test',
            'email'    => 'test@email.com',
            'password' => Hash::make('123456')
        ]);

        $office = Office::create([
            'name' => 'Test',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
            'image' => '',
        ]);

        $this->officeId = $office->id;
    }

    /** @test */
    public function should_be_able_to_register_office()
    {
        $response = $this->apiAs('POST', 'offices', [
            'image' => 'images/noimage.png',
            'name' => 'Escritório Copacabana',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'city',
            'state',
            'image',
        ]);
    }

    /** @test */
    public function should_not_be_able_register_office_with_duplicated_info()
    {
        $response = $this->apiAs('POST', 'offices', [
            'image' => 'images/noimage.png',
            'name' => 'Test',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
        ]);

        $response->assertStatus(422);
    }

    public function should_not_be_able_register_office_missing_field()
    {
        $response = $this->apiAs('POST', 'offices', [
            'name' => 'Nome nao duplicado',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function should_be_able_list_all_offices()
    {
        $response = $this->apiAs('GET', 'offices', []);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            [
                'id',
                'name',
                'city',
                'state',
                'image',
            ],
        ]);
    }

    /** @test */
    public function should_not_be_able_create_office_missing_authorization()
    {
        $response = $this->apiAs('POST', 'offices', [
            'image' => 'images/noimage.png',
            'name' => 'Test 02',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
        ], true);

        $response->assertStatus(401);
    }

    /** @test */
    public function should_not_be_able_list_offices_missing_authorization()
    {
        $response = $this->apiAs('GET', 'offices', [], true);

        $response->assertStatus(401);
    }
}
