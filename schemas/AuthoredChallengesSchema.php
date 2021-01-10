<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;

/**
 * Class AuthoredChallengesSchema
 * @package CodewarsKataExporter\Schemas
 */
final class AuthoredChallengesSchema implements SchemaInterface
{
    private array $data;

    /**
     * AuthoredChallengesSchema constructor
     *
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
    private function getSchema(): Schema
    {
        return Schema::parse([
            "data:array" => [
                "id:string",
                "name:string",
                "description:string",
                "rank:int",
                "rankName:string",
                "tags:array" => "string",
                "languages:array" => "string"
            ]
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