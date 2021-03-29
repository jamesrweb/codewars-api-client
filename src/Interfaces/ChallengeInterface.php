<?php

declare(strict_types=1);

namespace CodewarsApiClient\Interfaces;

interface ChallengeInterface
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
}
