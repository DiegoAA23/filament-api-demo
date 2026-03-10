<?php

namespace App\Filament\Helper;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class CustomLogin extends Login
{
    protected $baseUrl = 'https://va-backend.test/api/v1/auth/';

    public function authenticate(): ?LoginResponse
    {
        $agent = new Agent();
        $data = $this->form->getState();

        $email = $data['email'];
        $password = $data['password'];
        $browser = $agent->browser();
        $device = $agent->device();
        $platform = $agent->platform();
        $ipAddress = request()->ip();

        $parts = array_filter([$browser, $device, $platform, $ipAddress]);
        $device_name = implode(' / ', $parts);

        $response = Http::withoutVerifying()->post($this->baseUrl . 'login', [
            'email' => $email,
            'password' => $password,
            'device_name' => $device_name
        ]);

        if (! $response->status() == 200) {
            $this->throwFailureValidationException();
        }

        session()->regenerate();

        $responseData = $response->json();
        $token = $responseData['data']['token'];

        $user = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
            ->get($this->baseUrl . 'me');

        //dd($user->json());

        return app(CustomLoginResponse::class);
    }
}
