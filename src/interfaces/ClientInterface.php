<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface ClientInterface
{
    /**
     * @return array<mixed>
     */
    public function challenge(string $id): array;

    /**
     * @param array<string> $challenges
     *
     * @return array<mixed>
     */
    public function challenges(array $challenges): array;

    /**
     * @return array<mixed>
     */
    public function user(string $username): array;

    /**
     * @return array<mixed>
     */
    public function completed(string $username): array;

    /**
     * @return array<mixed>
     */
    public function authored(string $username): array;
}
