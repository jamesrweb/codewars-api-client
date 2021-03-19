<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface SchemaInterface
{
    public function validate(array $data): bool;
}
