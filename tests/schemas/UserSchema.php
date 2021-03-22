<?php

declare(strict_types=1);

namespace Tests\Schemas;

use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class UserSchema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    protected function schema(): Schema
    {
        return Expect::structure([
            'username' => Expect::string()->required(),
            'name' => Expect::string()->required(),
            'honor' => Expect::int()->required(),
            'clan' => Expect::string()->required(),
            'leaderboardPosition' => Expect::int()->required(),
            'skills' => Expect::arrayOf(Expect::string())->required(),
            'ranks' => Expect::structure([
                'overall' => Expect::structure([
                    'rank' => Expect::int()->required(),
                    'name' => Expect::string()->required(),
                    'color' => Expect::string()->required(),
                    'score' => Expect::int()->required(),
                ])->required(),
                'languages' => Expect::arrayOf(
                    Expect::structure([
                        'rank' => Expect::int()->required(),
                        'name' => Expect::string()->required(),
                        'color' => Expect::string()->required(),
                        'score' => Expect::int()->required(),
                    ]),
                    Expect::string()
                )->required(),
            ])->required(),
            'codeChallenges' => Expect::structure([
                'totalAuthored' => Expect::int()->required(),
                'totalCompleted' => Expect::int()->required(),
            ])->required(),
        ]);
    }
}
