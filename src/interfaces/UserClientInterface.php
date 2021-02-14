<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Interfaces;

interface UserClientInterface
{
    public function user(string $username): array;

    public function completed(string $username): array;

    public function authored(string $username): array;
}
