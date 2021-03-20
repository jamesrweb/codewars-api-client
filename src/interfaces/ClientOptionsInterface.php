<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface ClientOptionsInterface
{
    /**
     * Generate the headers required for each request the client makes.
     *
     * @return array<string, string>
     */
    public function headers(): array;
}
