<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Interfaces;

interface ClientInterface
{
    public function challenge(string $id): array;

    public function challenges(array $challenges): array;

    public function user(string $username): array;

    public function completed(string $username): array;

    public function authored(string $username): array;
}
