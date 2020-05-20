<?php

namespace Tests\Feature;

use App\Plan;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use DatabaseMigrations;

    protected $planId;

    public function setUp(): void
    {
        parent::setUp();

        User::create([
            'name' => 'Test',
            'email'    => 'test@email.com',
            'password' => Hash::make('123456')
        ]);

        $plan = Plan::create([
            'name' => 'Test',
            'monthly_cost' => 'R$ 450,00',
        ]);

        $this->planId = $plan->id;
    }

    /** @test */
    public function should_be_able_to_register_plan()
    {
        $response = $this->apiAs('POST', 'plans', [
            'name' => 'Escritório Copacabana',
            'monthly_cost' => 'R$600,00',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'monthly_cost',
        ]);
    }

    /** @test */
    public function should_not_be_able_register_plan_with_duplicated_info()
    {
        $response = $this->apiAs('POST', 'plans', [
            'name' => 'Test',
            'monthly_cost' => 'R$800,00',
        ]);

        $response->assertStatus(422);
    }

    public function should_not_be_able_register_plan_missing_field()
    {
        $response = $this->apiAs('POST', 'plans', [
            'name' => 'Not work too',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function should_be_able_list_all_plans()
    {
        $response = $this->apiAs('GET', 'plans', []);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            [
                'id',
                'name',
                'monthly_cost',
            ],
        ]);
    }

    /** @test */
    public function should_not_be_able_create_plan_missing_authorization()
    {
        $response = $this->apiAs('POST', 'plans', [
            'name' => 'Escritório Plaza',
            'monthly_cost' => 'R$600,00',
        ], true);

        $response->assertStatus(401);
    }

    /** @test */
    public function should_not_be_able_list_plans_missing_authorization()
    {
        $response = $this->apiAs('GET', 'plans', [], true);

        $response->assertStatus(401);
    }
}
