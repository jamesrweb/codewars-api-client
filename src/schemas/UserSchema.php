<?php

declare(strict_types=1);

namespace CodewarsApiClient\Schemas;

use CodewarsApiClient\Interfaces\SchemaInterface;
use Garden\Schema\Schema;

final class UserSchema implements SchemaInterface
{
    public function validate(array $data): bool
    {
        return $this->schema()->isValid($data);
    }

    private function schema(): Schema
    {
        return Schema::parse([
            'username:string',
            'name:string',
            'honor:int',
            'clan:string?',
            'leaderboardPosition:int',
            'skills:array' => 'string',
            'ranks:object' => [
                'overall:object' => [
                    'rank:int',
                    'name:string',
                    'color:string',
                    'score:int',
                ],
                'languages:object' => 'object',
            ],
            'codeChallenges:object' => [
                'totalAuthored:int',
                'totalCompleted:int',
            ],
        ]);
    }
}
