<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;

/**
 * Class CompletedChallengesSchema
 * @package CodewarsKataExporter\Schemas
 */
class CompletedChallengesSchema
{
    private array $data;

    /**
     * CompletedChallengesSchema constructor
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
            "totalPages:int",
            "totalItems:int",
            "data:array" => [
                "id:string",
                "name:string",
                "slug:string",
                "completedAt:string",
                "completedLanguages:array" => "string"
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