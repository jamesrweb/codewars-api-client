<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface UserInterface {
    /**
     * Get information about a given user.
     *
     * @return array<string, mixed>
     */
    public function user(string $username): array;

    /**
     * Get a list of challenges that have been authored by a given user.
     *
     * @return array<string, mixed>
     */
    public function authored(string $username): array;

    /**
     * Get a list of challenges that have been completed by a given user.
     *
     * @return array<string, mixed>
     */
    public function completed(string $username): array;
}