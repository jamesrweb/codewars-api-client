<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Interfaces;

interface ChallengeClientInterface
{
    public function challenge(string $id): array;

    public function challenges(array $challenges): array;
}
