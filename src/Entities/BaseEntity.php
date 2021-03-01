<?php

declare(strict_types=1);

namespace Webparking\LaravelClio\Entities;

use function GuzzleHttp\Psr7\build_query;
use Illuminate\Support\Collection;
use stdClass;
use Webparking\LaravelClio\APIClient;

abstract class BaseEntity
{
    protected APIClient $apiClient;

    protected string $endpoint;

    public function __construct(APIClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /** @param array<int, int|string> $fields */
    protected function baseGet(array $fields = []): ?stdClass
    {
        $request = $this->apiClient->getProvider()->getAuthenticatedRequest(
            'GET',
            $this->buildUri([], $fields),
            $this->apiClient->getToken()
        );

        $json = json_decode($this->apiClient->getProvider()->getResponse($request)->getBody()->getContents());

        if (isset($json->data)) {
            return (object) $json->data;
        }

        return null;
    }

    /**
     * @param  array<string, int|string> $params
     * @param  array<int, int|string>    $fields
     * @return Collection<mixed>
     */
    protected function baseIndex(array $params = [], array $fields = []): collection
    {
        $request = $this->apiClient->getProvider()->getAuthenticatedRequest(
            'GET',
            $this->buildUri($params, $fields),
            $this->apiClient->getToken()
        );

        $json = json_decode($this->apiClient->getProvider()->getResponse($request)->getBody()->getContents());

        if (isset($json->data)) {
            return collect($json->data);
        }

        return collect($json);
    }

    /** @param array<string, mixed> $data */
    protected function basePost(array $data): ?stdClass
    {
        $request = $this->apiClient->getProvider()->getAuthenticatedRequest(
            'POST',
            $this->buildUri([]),
            $this->apiClient->getToken(),
            [
                'headers' => ['content-type' => 'application/json'],
                'body' => json_encode(['data' => $data]),
            ]
        );

        $json = json_decode($this->apiClient->getProvider()->getResponse($request)->getBody()->getContents());

        if (isset($json->data)) {
            return (object) $json->data;
        }

        return null;
    }

    /** @param array<string, string> $data */
    protected function basePatch(array $data): ?stdClass
    {
        $request = $this->apiClient->getProvider()->getAuthenticatedRequest(
            'PATCH',
            $this->buildUri([]),
            $this->apiClient->getToken(),
            [
                'headers' => ['content-type' => 'application/json'],
                'body' => json_encode(['data' => $data]),
            ]
        );

        $json = json_decode($this->apiClient->getProvider()->getResponse($request)->getBody()->getContents());

        if (isset($json->data)) {
            return (object) $json->data;
        }

        return null;
    }

    /**
     * @param array<string, int|string> $params
     * @param array<int,int|string>     $fields
     */
    public function buildUri(array $params = [], array $fields = [], bool $appendJsonPostfix = true): string
    {
        $uri = implode(
            '/',
            array_filter(
                [
                    config('clio.api_url') ? config('clio.eu_api_url') : config('clio.api_url'),
                    $this->getEndpoint(),
                ]
            ),
        );

        if ($appendJsonPostfix) {
            $uri .= '.json';
        }

        if ($fields) {
            $uri .= '?fields=' . implode(',', $fields);
        }

        if (!$params) {
            return $uri;
        }

        return $uri . (!empty($fields) ? '&' : '?') . build_query($params);
    }

    public function getEndpoint(): string
    {
        if (empty($this->endpoint)) {
            throw new \RuntimeException('Endpoint not set!');
        }

        return $this->endpoint;
    }
}
