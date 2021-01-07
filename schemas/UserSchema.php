<?php

namespace CodewarsKataExporter\Schemas;

use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;

/**
 * Class UserSchema
 * @package CodewarsKataExporter\Schemas
 */
class UserSchema
{
    public array $data = [];

    /**
     * UserSchema constructor
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the parsed schema to validate the data on
     *
     * @return Schema
     */
    public function getSchema(): Schema
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
            "codeChallenges:object"
        ]);
    }

    /**
     * Validate the schema
     *
     * @return bool
     * @throws RefNotFoundException
     */
    public function validate(): bool
    {
        return $this->getSchema()->isValid($this->data);
    }
}