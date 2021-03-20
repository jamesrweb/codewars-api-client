<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface SchemaInterface
{
    /**
     * Validate provided data against the schema.
     *
     * @param array<mixed> $data
     */
    public function validate(array $data): bool;
}
