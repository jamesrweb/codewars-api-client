<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use CodewarsKataExporter\Interfaces\SchemaInterface;
use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;

/**
 * Class CompletedChallengesSchema
 * @package CodewarsKataExporter\Schemas
 */
final class CompletedChallengesSchema implements SchemaInterface
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
            ":array" => [
                "id:string",
                "name:string?",
                "slug:string?",
                "completedAt:dt",
                "completedLanguages:array" => "string"
            ]
        ]);
    }
}