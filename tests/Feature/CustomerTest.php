<?php

namespace Tests\Feature;

use App\Customer;
use App\Office;
use App\Plan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    protected $officeId;
    protected $planId;

    protected $customerId;

    public function setUp(): void
    {
        parent::setUp();

        $office = Office::create([
            'name' => 'Test',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
            'image' => '',
        ]);

        $this->officeId = $office->id;

        $plan = Plan::create([
            'name' => 'Test',
            'monthly_cost' => 'R$ 450,00',
        ]);

        $this->planId = $plan->id;

        $customer = Customer::create([
            'name' => 'Eleanor Test',
            'is_company' => '0',
            'document' => '999.123.234-44',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $this->customerId = $customer->id;
    }

    /** @test */
    public function should_be_able_to_register_customer_with_cpf()
    {
        $response = $this->apiAs('POST', 'customers', [
            'name' => 'John Test',
            'is_company' => '0',
            'document' => '123.520.123-58',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'is_company',
            'document',
            'office',
            'plan',
        ]);
    }

    /** @test */
    public function should_be_able_to_register_customer_with_cnpj()
    {
        $response = $this->apiAs('POST', 'customers', [
            'name' => 'Mike Test',
            'is_company' => '1',
            'document' => '12.122.323/4444-99',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'is_company',
            'document',
            'office',
            'plan',
        ]);
    }

    /** @test */
    public function should_not_be_able_register_customer_with_duplicated_cpf()
    {
        $response = $this->apiAs('POST', 'customers', [
            'name' => 'Testana',
            'is_company' => '0',
            'document' => '999.123.234-44',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function should_not_be_able_register_customer_with_duplicated_cnpj()
    {
        Customer::create([
            'name' => 'Bruna Test',
            'is_company' => '1',
            'document' => '99.123.234/5644-44',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $response = $this->apiAs('POST', 'customers', [
            'name' => 'Bruna Test',
            'is_company' => '1',
            'document' => '99.123.234/5644-44',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function should_not_be_able_register_customer_missing_field()
    {
        $response = $this->apiAs('POST', 'customers', [
            'is_company' => '1',
            'document' => '23.434.999/6678-99',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function should_be_able_list_all_customers()
    {
        $response = $this->apiAs('GET', 'customers', []);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            [
                'name',
                'is_company',
                'document',
                'office' => [
                    'id',
                    'name',
                ],
                'plan' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    /** @test */
    public function should_not_be_able_create_office_missing_authorization()
    {
        $response = $this->apiAs('POST', 'offices', [
            'name' => 'Carlos Test',
            'is_company' => '1',
            'document' => '33.934.988/1678-99',
            'office_id' => $this->officeId,
            'plan_id' => $this->planId,
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
