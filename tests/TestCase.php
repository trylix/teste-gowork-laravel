<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function apiAs(
        $method,
        $uri,
        array $data = [],
        $disableToken = false,
        array $headers = [],
        $user = null
    ) {
        $user = $user ? $user : factory(User::class)->create();

        if (!$disableToken) {
            $headers = array_merge(
                ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)],
                $headers
            );
        }

        return $this->json($method, "api/$uri", $data, $headers);
    }
}
