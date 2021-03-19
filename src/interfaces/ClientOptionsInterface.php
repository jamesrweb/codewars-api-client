<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface ClientOptionsInterface
{
    /**
     * @return array<string, string>
     */
    public function headers(): array;
}
