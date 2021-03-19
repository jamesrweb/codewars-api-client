<?php

declare(strict_types=1);

namespace CodewarsApiClient\Schemas;

use CodewarsApiClient\Interfaces\SchemaInterface;
use Garden\Schema\Schema;

final class ChallengeSchema implements SchemaInterface
{
    public function validate(array $data): bool
    {
        return $this->schema()->isValid($data);
    }

    private function schema(): Schema
    {
        return Schema::parse([
            'id:string',
            'name:string',
            'slug:string',
            'category:string',
            'publishedAt:string',
            'approvedAt:string',
            'languages:array' => 'string',
            'url:string',
            'rank:object' => [
                'id:int',
                'name:string',
                'color:string',
            ],
            'createdBy:object' => [
                'username:string',
                'url:string',
            ],
            'approvedBy:object' => [
                'username:string',
                'url:string',
            ],
            'description:string',
            'totalAttempts:int',
            'totalCompleted:int',
            'totalStars:int',
            'tags:array' => 'string',
        ]);
    }
}
