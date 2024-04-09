<?php

namespace BeraniDigital\LibraryLaravelLogtoIo;

use BeraniDigital\LibraryLaravelLogtoIo\Extensions\LaravelSession;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Logto\Sdk\LogtoClient;
use Logto\Sdk\LogtoConfig;
use Logto\Sdk\Models\OidcProviderMetadata;
use Logto\Sdk\Oidc\OidcCore;
use Phpfastcache\CacheManager;

class LibraryLaravelLogtoIo extends LogtoClient
{
    public function __construct()
    {
        $endpoint = config('logto-io.endpoint');
        $appId = config('logto-io.app_id');
        $appSecret = config('logto-io.app_secret');
        $leeWay = config('logto-io.lee_way');
        JWT::$leeway = $leeWay;
        if (empty($endpoint) || empty($appId) || empty($appSecret)) {
            throw new \Exception('Logto configuration is not set');
        }
        $this->config = new LogtoConfig(
            config('logto-io.endpoint'),
            config('logto-io.app_id'),
            config('logto-io.app_secret')
        );
        $this->storage = new LaravelSession();
        $this->oidcCore = self::create($this->config->endpoint);

    }

    protected static function create(string $logtoEndpoint): OidcCore
    {
        $cacheManager = CacheManager::getInstance('files');
        $cacheObject = $cacheManager->getItem('logto-oidc-configuration-' . urlencode($logtoEndpoint));
        $cachedConfiguration = $cacheObject->get();
        if (!$cachedConfiguration) {
            $client = new Client();
            $cachedConfiguration = $client->get(
                $logtoEndpoint . '/oidc/.well-known/openid-configuration',
                ['headers' => ['user-agent' => '@logto/php', 'accept' => '*/*']]
            )->getBody()->getContents();
            $cacheObject->set($cachedConfiguration)->expiresAfter(3600);// 1 hour
            $cacheManager->save($cacheObject);
        }
        return new OidcCore(new OidcProviderMetadata(...json_decode($cachedConfiguration, true)));
    }
    public function getSubject(): string
    {
        return $this->fetchUserInfo()->sub;
    }

    public function config(): LogtoConfig
    {
        return $this->config;
    }

    public function handleSignInCallback(): void
    {
        if (!($_SERVER['PATH_INFO'] ?? null)) {
            $_SERVER['PATH_INFO'] = parse_url($this->getSignInSession()->redirectUri, PHP_URL_PATH);
        }

        parent::handleSignInCallback();
    }
}
