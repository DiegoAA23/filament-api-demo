<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ApiUserProvider implements UserProvider
{
    /**
     * Rebuild the user from the session-stored API data.
     * Laravel calls this on every request to "re-hydrate" the authenticated user.
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        $apiUserData = session('api_user_data');

        if (!$apiUserData || ($apiUserData['id'] ?? null) != $identifier) {
            return null;
        }

        $user = new ApiUser($apiUserData);
        $user->exists = true;

        return $user;
    }

    // ── The methods below are unused (no DB, no tokens, no credentials check here) ──

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        // not needed
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return false;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
        // not needed
    }
}