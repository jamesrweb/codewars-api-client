<?php

declare(strict_types=1);

namespace Tests\Schemas;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use function Tests\Helpers\ISO8601_pattern;

final class CompletedChallengesSchema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    protected function schema(): Schema
    {
        return Expect::arrayOf(Expect::structure([
            'id' => Expect::string()->required(),
            'name' => Expect::string()->required(),
            'slug' => Expect::string()->required(),
            'completedAt' => Expect::string()->pattern(ISO8601_pattern())->required(),
            'completedLanguages' => Expect::arrayOf(Expect::string())->required(),
        ]));
    }
}
