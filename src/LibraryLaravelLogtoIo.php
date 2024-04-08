<?php

namespace BeraniDigital\LibraryLaravelLogtoIo;

use BeraniDigital\LibraryLaravelLogtoIo\Extensions\LaravelSession;
use Logto\Sdk\LogtoClient;
use Logto\Sdk\LogtoConfig;

class LibraryLaravelLogtoIo extends LogtoClient
{


    public function __construct()
    {
        $endpoint = config('logto-io.endpoint');
        $appId = config('logto-io.app_id');
        $appSecret = config('logto-io.app_secret');
        if (empty($endpoint) || empty($appId) || empty($appSecret)) {
            throw new \Exception('Logto configuration is not set');
        }
        parent::__construct(new LogtoConfig(
            config('logto-io.endpoint'),
            config('logto-io.app_id'),
            config('logto-io.app_secret')
        ), new LaravelSession());

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
