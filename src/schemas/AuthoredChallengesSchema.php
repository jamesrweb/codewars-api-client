<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use CodewarsKataExporter\Interfaces\SchemaInterface;
use Garden\Schema\Schema;

final class AuthoredChallengesSchema implements SchemaInterface
{
    public function validate(array $data): bool
    {
        return $this->schema()->isValid($data);
    }

    private function schema(): Schema
    {
        return Schema::parse([
            ':array' => [
                'id:string',
                'name:string',
                'description:string',
                'rank:int',
                'rankName:string',
                'tags:array' => 'string',
                'languages:array' => 'string',
            ],
        ]);
    }
}
