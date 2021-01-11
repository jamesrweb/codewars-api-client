<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;

/**
 * Class UserSchema
 * @package CodewarsKataExporter\Schemas
 */
final class UserSchema implements SchemaInterface
{
    /**
     * Validate the schema
     *
     * @param array $data
     * @return bool
     * @throws RefNotFoundException
     */
    public function validate(array $data): bool
    {
        return $this->schema()->isValid($data);
    }

    /**
     * Get the schema used for validation
     *
     * @return Schema
     */
    public function schema(): Schema
    {
        return Schema::parse([
            "username:string",
            "name:string",
            "honor:int",
            "clan:string?",
            "leaderboardPosition:int",
            "skills:array" => "string",
            "ranks:object" => [
                "overall:object" => [
                    "rank:int",
                    "name:string",
                    "color:string",
                    "score:int"
                ],
                "languages:object" => "object"
            ],
            "codeChallenges:object" => [
                "totalAuthored:int",
                "totalCompleted:int"
            ]
        ]);
    }
}