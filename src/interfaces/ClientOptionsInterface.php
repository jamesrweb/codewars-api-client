<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Interfaces;

/**
 * Interface ClientOptionsInterface
 * @package CodewarsKataExporter\Interfaces
 */
interface ClientOptionsInterface
{
    public function username(): string;

    public function headers(): array;
}