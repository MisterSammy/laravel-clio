<?php

declare(strict_types=1);

namespace Webparking\LaravelClio\Entities;

use Illuminate\Support\Collection;
use stdClass;

class Matter extends BaseEntity
{
    protected string $endpoint = 'matters';

    /**
     * @param  array<string, int|string> $params
     * @param  array<int, int|string>    $fields
     * @return Collection<mixed>
     */
    public function index(array $params = [], array $fields = []): collection
    {
        return $this->baseIndex($params, $fields);
    }

    /** @param  array<int, int|string>  $fields */
    public function get(int $id, array $fields = []): ?stdClass
    {
        $this->endpoint .= '/' . $id;

        return $this->baseGet($fields);
    }

    public function preview(int $id): string
    {
        $this->endpoint .= '/' . $id . '/preview.html';

        $request = $this->apiClient->getProvider()->getAuthenticatedRequest(
            'GET',
            $this->buildUri([], [], false),
            $this->apiClient->getToken()
        );

        return $this->apiClient->getProvider()->getResponse($request)->getBody()->getContents();
    }

    /** @param array<string, string> $data */
    public function update(int $id, array $data): ?stdClass
    {
        $this->endpoint .= '/' . $id;

        return $this->basePatch($data);
    }
}
