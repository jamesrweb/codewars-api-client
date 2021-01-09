<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

/**
 * Interface ClientOptionsInterface
 * @package CodewarsKataExporter
 */
interface ClientOptionsInterface
{
    public function getUsername(): string;

    public function setUsername(string $username): void;

    public function getApiKey(): ?string;

    public function setApiKey(string $api_key): void;
}