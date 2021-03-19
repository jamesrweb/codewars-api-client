<?php

declare(strict_types=1);

namespace CodewarsApiClient\Schemas;

use function CodewarsApiClient\Helpers\ISO8601_pattern;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class CompletedChallengesSchema extends AbstractSchema
{
    protected function schema(): Schema
    {
        $completed_challenge = Expect::structure([
            'id' => Expect::string()->required(),
            'name' => Expect::string()->required(),
            'slug' => Expect::string()->required(),
            'completedAt' => Expect::string()->pattern(ISO8601_pattern())->required(),
            'completedLanguages' => Expect::arrayOf(Expect::string())->required(),
        ]);

        return Expect::arrayOf($completed_challenge);
    }
}
