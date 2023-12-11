<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Transaction;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    public function test_users_can_authenticate_using_session(): void
    {
        $user = $this->user;

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
    }

    public function test_users_can_authenticate_and_get_token(): void
    {
        $user = $this->user;

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $this->assertSuccessAndSee($response,'token');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = $this->user;

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
