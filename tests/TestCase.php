<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication ,RefreshDatabase;
    protected $admin;
    protected $customer;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = $this->createAdmin();
        $this->customer = $this->createCustomer();
        $this->user =  $this->createUser();
    }

    protected function createAdmin()
    {
        $user = $this->createUser();
        $user->assignRole('admin');
        return $user;
    }

    protected function createCustomer()
    {
        $user = $this->createUser();
        $user->assignRole('customer');
        return $user;
    }

    protected function createUser()
    {
        return User::factory()->create();
    }

    protected function assertUnauthorized($response)
    {
        return $response->assertStatus(403)->assertJson([
            'success' => false,
            'message' => 'User does not have the right roles.'
           
        ]);
    }

    protected function assertSuccessAndSee($response,$data)
    {
        return $response->assertStatus(200)->assertSee($data);
    }

}
