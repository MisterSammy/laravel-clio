<?php

declare(strict_types=1);

namespace Webparking\LaravelClio\Entities;

use Illuminate\Support\Collection;
use stdClass;

class Communication extends BaseEntity
{
    protected string $endpoint = 'communications';

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

    /** @param array<string, mixed> $data */
    public function store(array $data): ?stdClass
    {
        return $this->basePost($data);
    }

    /** @param array<string, string> $data */
    public function update(int $id, array $data): ?stdClass
    {
        $this->endpoint .= '/' . $id;

        return $this->basePatch($data);
    }
}
