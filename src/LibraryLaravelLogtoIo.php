<?php

namespace BeraniDigital\LibraryLaravelLogtoIo;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Logto\Sdk\InteractionMode;
use Logto\Sdk\LogtoClient;
use Logto\Sdk\LogtoConfig;

class LibraryLaravelLogtoIo extends LogtoClient
{


    public function __construct()
    {
        $endpoint = config('log-to.endpoint');
        $appId = config('log-to.app_id');
        $appSecret = config('log-to.app_secret');
        if (empty($endpoint) || empty($appId) || empty($appSecret)) {
            throw new \Exception('Logto configuration is not set');
        }
        parent::__construct(new LogtoConfig(
            config('log-to.endpoint'),
            config('log-to.app_id'),
            config('log-to.app_secret')
        ));

    }

    public function getSubject(): string
    {
        return $this->fetchUserInfo()->sub;
    }
    public function config(): LogtoConfig
    {
        return $this->config;
    }


}
