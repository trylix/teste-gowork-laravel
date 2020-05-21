<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $user = new User([
            'name' => 'Test',
            'email'    => 'test@email.com',
            'password' => Hash::make('123456')
        ]);

        $user->save();
    }

    /** @test */
    public function should_be_able_to_login()
    {
        $response = $this->post('api/auth', [
            'email'    => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    /** @test */
    public function should_not_be_able_to_login()
    {
        $response = $this->post('api/auth', [
            'email'    => 'test@email.com',
            'password' => 'notlegitpassword'
        ]);

        $response->assertJsonStructure([
            'error',
        ]);
    }

    /** @test */
    public function should_be_able_to_register_user() {
        $response = $this->post('api/user', [
            'name' => 'Adriana Teste',
            'email' => 'test2020@gmail.com',
            'password' => 'umasenhaqualquuer',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function should_be_not_able_to_register_user_duplicated_email() {
        $response = $this->post('api/user', [
            'name' => 'Adriana Teste',
            'email' => 'test@email.com',
            'password' => 'umasenhaqualquuer',
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function should_be_not_able_to_register_user_missing_fields() {
        $response = $this->post('api/user', [
            'email' => 'test@email.com',
        ]);

        $response->assertStatus(302);
    }
}
