<?php

namespace Tests\Feature;

use App\Customer;
use App\Employee;
use App\Office;
use App\Plan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseMigrations;

    protected $officeId;
    protected $planId;
    protected $customerId;
    protected $employeeId;

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

        $employee = Employee::create([
            'name' => 'Funcionário 1',
            'customer_id' => $this->customerId,
            'office_id' => $this->officeId,
        ]);

        $this->employeeId = $employee->id;
    }

    /** @test */
    public function should_be_able_to_register_employee()
    {
        $response = $this->apiAs('POST', 'employees', [
            'name' => 'Jose Test',
            'customer_id' => $this->customerId,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'customer',
        ]);
    }

    /** @test */
    public function should_not_be_able_register_employee_missing_field()
    {
        $response = $this->apiAs('POST', 'employees', [
            'customer_id' => $this->customerId,
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function should_not_be_able_register_employee_with_invalid_customer_id()
    {
        $response = $this->apiAs('POST', 'employees', [
            'name' => 'Jose Test',
            'customer_id' => 99,
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function should_be_able_list_all_employees_by_customer_id()
    {
        $response = $this->apiAs('GET', "employees/$this->customerId", []);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            [
                'id',
                'name',
                'customer',
            ],
        ]);
    }

    /** @test */
    public function should_not_be_able_create_employee_missing_authorization()
    {
        $response = $this->apiAs('POST', 'employees', [
            'name' => 'Jose Dantas',
            'customer_id' => $this->customerId,
        ], true);

        $response->assertStatus(401);
    }

    /** @test */
    public function should_not_be_able_list_employees_missing_authorization()
    {
        $response = $this->apiAs('GET', 'employees', [], true);

        $response->assertStatus(401);
    }
}
