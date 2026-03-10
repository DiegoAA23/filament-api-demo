<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected $baseUrl = 'https://va-backend.test/api/v1/auth/register';

    protected function handleRecordCreation(array $data): Model
    {
        $agent = new Agent();

        $browser = $agent->browser();
        $device = $agent->device();
        $platform = $agent->platform();
        $ipAddress = request()->ip();


        $parts = array_filter([$browser, $device, $platform, $ipAddress]);

        $device_name = implode(' / ', $parts);

        $response = Http::post($this->baseUrl, [
            'name' => $data['name'],
            'password' => $data['password'],
            'email' => $data['email'],
            'password_confirmation' => $data['password'],
            'device_name' => $device_name
        ]);

        if ($response->failed()) {
            $errors = $response->json('errors') ?? [];

            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title(str($field)->replace('_', ' ')->title())
                        ->body($message)
                        ->danger()
                        ->persistent()
                        ->send();
                }
            }
            throw new Halt();
        }

        return new (static::getModel());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Usuario creado';
    }
}
