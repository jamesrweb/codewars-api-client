<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

/**
 * Interface UserInterface
 * @package CodewarsKataExporter
 */
interface UserInterface
{
    public function userOverview(): array;

    public function completedChallenges(): array;

    public function authoredChallenges(): array;
}