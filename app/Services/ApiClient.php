<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://va-backend.test/api/v1/auth/';
    }

    protected function client()
    {
        return Http::withoutVerifying()
            ->baseUrl($this->baseUrl)
            ->withToken(session('api_token'));
    }

    public function login($email, $password, $device)
    {
        return Http::withoutVerifying()->post('login', [
            'email' => $email,
            'password' => $password,
            'device_name' => $device,
        ]);
    }

    public function me()
    {
        return $this->client()->get('me');
    }
}
