<?php

declare(strict_types=1);

namespace Webparking\LaravelClio;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

class APIClient
{
    /** @var GenericProvider */
    private $provider;

    /** @var string */
    private $state = null;

    /** @var string */
    private $token = null;

    public function connect(string $accessToken = null): self
    {
        $this->provider = new GenericProvider([
            'clientId' => config('clio.client_id'),
            'clientSecret' => config('clio.client_secret'),
            'redirectUri' => config('clio.callback_url'),
            'urlAuthorize' => config('clio.eu_client') ? config('clio.eu_authorize_url') : config('clio.authorize_url'),
            'urlAccessToken' => config('clio.eu_client') ? config('clio.eu_token_url') : config('clio.token_url'),
            'urlResourceOwnerDetails' => '',
        ]);

        if ($accessToken) {
            $this->setToken($accessToken);
        }

        return $this;
    }

    public function getProvider(): GenericProvider
    {
        if (empty($this->provider)) {
            $this->connect();
        }

        return $this->provider;
    }

    public function getAuthorizationUrl(): string
    {
        return $this->getProvider()->getAuthorizationUrl([
            'state' => $this->getState(),
            'redirect_uri' => config('clio.callback_url'),
        ]);
    }

    public function getAccessToken(string $authorizationCode): AccessTokenInterface
    {
        return $this->getProvider()->getAccessToken('authorization_code', ['code' => $authorizationCode]);
    }

    public function refreshAccessToken(string $refreshToken): AccessTokenInterface
    {
        return $this->getProvider()->getAccessToken('refresh_token', ['refresh_token' => $refreshToken]);
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
