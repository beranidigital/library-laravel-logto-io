<?php

namespace BeraniDigital\LibraryLaravelLogtoIo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BeraniDigital\LibraryLaravelLogtoIo\LibraryLaravelLogtoIo
 *
 * @mixin \BeraniDigital\LibraryLaravelLogtoIo\LibraryLaravelLogtoIo
 *
 * @method static fetchUserInfo(): Logto\Sdk\Oidc\UserInfoResponse
 * @method static signIn(string $route)
 * @method static signOut(?string $postLogoutRedirectUri = null): string
 * @method static isAuthenticated(): bool
 * @method static getIdTokenClaims()
 * @method static handleSignInCallback()
 * @method static \Logto\Sdk\LogtoConfig config()
 */
class LibraryLaravelLogtoIo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BeraniDigital\LibraryLaravelLogtoIo\LibraryLaravelLogtoIo::class;
    }
}
