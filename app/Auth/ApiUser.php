<?php

namespace App\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;

class ApiUser extends Authenticatable implements FilamentUser, HasName
{
    public array $apiUser;

    protected $guard = 'api-session';

    public $exists = true;

    // Tell Eloquent not to try DB operations
    protected $table = null;

    public function __construct(array $apiUser)
    {
        $this->apiUser = $apiUser;
    }

    // ── Filament contracts ────────────────────────────────────────────────────

    public function getFilamentName(): string
    {
        return $this->apiUser['name'] ?? 'User';
    }

    // NOTE: Data is nested under $user->apiUser — all access goes through here

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    // ── Laravel Auth contracts ────────────────────────────────────────────────

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->apiUser['id'];
    }

    public function getAuthPassword(): string
    {
        return '';
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void {}

    public function getRememberTokenName(): string
    {
        return '';
    }

    // ── Attribute access ──────────────────────────────────────────────────────

    public function getAttribute($key): mixed
    {
        return $this->apiUser[$key] ?? parent::getAttribute($key);
    }

    public function __get($key): mixed
    {
        return $this->apiUser[$key] ?? null;
    }

    public function __isset($key): bool
    {
        return isset($this->apiUser[$key]);
    }
}
