<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

/**
 * Interface ClientOptionsInterface
 * @package CodewarsKataExporter
 */
interface ClientOptionsInterface
{
    public function username(): string;

    public function headers(): array;
}