<?php

declare(strict_types=1);

namespace CodewarsApiClient\Tests\Schemas;

use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class AuthoredChallengesSchema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    protected function schema(): Schema
    {
        return Expect::arrayOf(Expect::structure([
            'id' => Expect::string()->required(),
            'name' => Expect::string()->required(),
            'description' => Expect::string()->required(),
            'rank' => Expect::int()->required(),
            'rankName' => Expect::string()->required(),
            'tags' => Expect::arrayOf(Expect::string())->required(),
            'languages' => Expect::arrayOf(Expect::string())->required(),
        ]));
    }
}
