<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface ClientInterface
{
    /**
     * Get information about a challenge by it's ID.
     *
     * @return array<string, mixed>
     */
    public function challenge(string $id): array;

    /**
     * Get information about multiple challenges by their IDs.
     *
     * @param array<string> $challenges
     *
     * @return array<string, mixed>
     */
    public function challenges(array $challenges): array;

    /**
     * Get information about a given user.
     *
     * @return array<string, mixed>
     */
    public function user(string $username): array;

    /**
     * Get a list of challenges that have been completed by a given user.
     *
     * @return array<string, mixed>
     */
    public function completed(string $username): array;

    /**
     * Get a list of challenges that have been authored by a given user.
     *
     * @return array<string, mixed>
     */
    public function authored(string $username): array;
}
