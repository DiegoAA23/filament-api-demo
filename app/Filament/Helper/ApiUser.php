<?php

namespace App\Filament\Helper;

use Illuminate\Contracts\Auth\Authenticatable;

class ApiUser implements Authenticatable
{
    public $id;
    public $name;
    public $email;
    public $is_platform_admin;
    public $organizations;
    public $token;

    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getAuthPasswordName()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        //
    }

    public function getRememberTokenName()
    {
        return null;
    }
}
