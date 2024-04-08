# This is my package library-laravel-logto-io

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beranidigital/library-laravel-logto-io.svg?style=flat-square)](https://packagist.org/packages/beranidigital/library-laravel-logto-io)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/beranidigital/library-laravel-logto-io/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/beranidigital/library-laravel-logto-io/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/beranidigital/library-laravel-logto-io/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/beranidigital/library-laravel-logto-io/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/beranidigital/library-laravel-logto-io.svg?style=flat-square)](https://packagist.org/packages/beranidigital/library-laravel-logto-io)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require beranidigital/library-laravel-logto-io
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="library-laravel-logto-io-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="library-laravel-logto-io-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="library-laravel-logto-io-views"
```

## Usage

```php
// app/Policies/AppServiceProvider.php
      use BeraniDigital\LibraryLaravelLogtoIo\Facades\LibraryLaravelLogtoIo;
    public function register(): void
    {
        
        LibraryLaravelLogtoIo::config()->scopes = [
            \Logto\Sdk\Constants\UserScope::profile,
            \Logto\Sdk\Constants\UserScope::email,
            \Logto\Sdk\Constants\UserScope::phone,
            \Logto\Sdk\Constants\UserScope::identities,
            \Logto\Sdk\Constants\UserScope::roles,
        ];
        LibraryLaravelLogtoIo::config()->resources = [
          // add your resources here
        ];
    }
```

```php
// routes/web.php
Route::get('/auth/callback', function () {
    try {
        \BeraniDigital\LibraryLaravelLogtoIo\Facades\LibraryLaravelLogtoIo::handleSignInCallback();
    }catch (\Logto\Sdk\LogtoException $e){
        return redirect()->route('login')->with('error', $e->getMessage());
    }
    $logToUser = \BeraniDigital\LibraryLaravelLogtoIo\Facades\LibraryLaravelLogtoIo::fetchUserInfo();
    $user = \App\Models\User::where('logto_id', $logToUser->sub)->first();
    if(!$user){
        $user = new \App\Models\User;
        $user->logto_id = $logToUser->sub;
        $faker = \Faker\Factory::create();
        $user->name = $logToUser->name ?? $logToUser->username ?? $logToUser->email ?? $faker->numerify('User ####');
    }
    // always fetch latest user's email and phone number after login
    $user->phone = $logToUser->phone_number;
    $user->email = $logToUser->email;
    $user->email_verified_at = $logToUser->email_verified ? now() : null;
    $user->save();

    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('home');
})->name('auth.callback');

Route::get('/login', function () {
    return redirect(\BeraniDigital\LibraryLaravelLogtoIo\Facades\LibraryLaravelLogtoIo::signIn(route('auth.callback')));
})->name('login');

function logout() {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect(\BeraniDigital\LibraryLaravelLogtoIo\Facades\LibraryLaravelLogtoIo::signOut(route('home')));
}
Route::get('/logout', function () {
    return logout();
})->name('logout');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Yusuf Sekhan Althaf](https://github.com/Ticlext-Altihaf)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
