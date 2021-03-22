<?php

declare(strict_types=1);

namespace CodewarsApiClient\Tests\Schemas;

use function CodewarsApiClient\Tests\Helpers\ISO8601_pattern;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class ChallengeSchema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    protected function schema(): Schema
    {
        return Expect::structure([
            'id' => Expect::string()->required(),
            'name' => Expect::string()->required(),
            'slug' => Expect::string()->required(),
            'category' => Expect::string()->required(),
            'publishedAt' => Expect::string()->pattern(ISO8601_pattern())->required(),
            'approvedAt' => Expect::string()->pattern(ISO8601_pattern())->required(),
            'createdBy' => Expect::structure([
                'username' => Expect::string()->required(),
                'url' => Expect::string()->required(),
            ])->required(),
            'approvedBy' => Expect::structure([
                'username' => Expect::string()->required(),
                'url' => Expect::string()->required(),
            ])->required(),
            'languages' => Expect::arrayOf(Expect::string())->required(),
            'url' => Expect::string()->required(),
            'rank' => Expect::structure([
                'id' => Expect::int()->required(),
                'name' => Expect::string()->required(),
                'color' => Expect::string()->required(),
            ])->required(),
            'description' => Expect::string()->required(),
            'totalAttempts' => Expect::int()->required(),
            'totalCompleted' => Expect::int()->required(),
            'totalStars' => Expect::int()->required(),
            'tags' => Expect::arrayOf(Expect::string())->required(),
            /*
             * The keys below are added to fix an issue with broken API versioning on codewars side.
             *
             * @link https://github.com/codewars/codewars.com/issues/2347
             */
            'createdAt' => Expect::string()->pattern(ISO8601_pattern()),
            'voteScore' => Expect::int(),
            'contributorsWanted' => Expect::bool(),
            'unresolved' => Expect::structure([
                'issues' => Expect::int(),
                'suggestions' => Expect::int(),
            ]),
        ]);
    }
}
