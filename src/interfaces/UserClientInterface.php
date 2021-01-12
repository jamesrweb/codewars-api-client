<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Interfaces;

/**
 * Interface UserClientInterface
 * @package CodewarsKataExporter\Interfaces
 */
interface UserClientInterface
{
    public function user(): array;

    public function completed(): array;

    public function authored(): array;
}