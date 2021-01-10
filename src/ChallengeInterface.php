<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

/**
 * Interface ChallengeInterface
 * @package CodewarsKataExporter
 */
interface ChallengeInterface
{
    public function challenge(string $id): array;
}