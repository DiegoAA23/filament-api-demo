<?php

namespace App\Filament\Helper;

use App\Auth\ApiUser;
use App\Services\ApiClient;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class CustomLogin extends Login
{
    protected $baseUrl = 'https://va-backend.test/api/v1/auth/';

    public function authenticate(): ?LoginResponse
    {
        $agent    = new Agent();
        $data     = $this->form->getState();
        $email    = $data['email'];
        $password = $data['password'];

        $browser  = $agent->browser();
        $device   = $agent->device();
        $platform = $agent->platform();
        $ip       = request()->ip();

        $device_name = implode(' / ', array_filter([$browser, $device, $platform, $ip]));

        $response = Http::withoutVerifying()->post($this->baseUrl . 'login', [
            'email'       => $email,
            'password'    => $password,
            'device_name' => $device_name,
        ]);

        if ($response->failed()) {
            $this->throwFailureValidationException();
        }

        $token = $response->json()['data']['token'];

        session(['api_token' => $token]);

        $api = app(ApiClient::class);
        $apiUserData = $api->me()->json()['data'];

        session(['api_user_data' => $apiUserData]);

        $user = new ApiUser($apiUserData);
        $user->exists = true;
        //dd($response->json());
        Auth::guard('api-session')->login($user);
        session()->regenerate();

        return app(LoginResponse::class);
    }
}
