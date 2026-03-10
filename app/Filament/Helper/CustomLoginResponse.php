<?php

namespace App\Filament\Helper;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        return redirect()->intended('/admin');
    }
}
