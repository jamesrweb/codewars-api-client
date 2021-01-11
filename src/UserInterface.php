<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

/**
 * Interface UserInterface
 * @package CodewarsKataExporter
 */
interface UserInterface
{
    public function user(): array;

    public function completed(): array;

    public function authored(): array;
}