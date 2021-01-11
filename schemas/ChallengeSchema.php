<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;

/**
 * Class ChallengeSchema
 * @package CodewarsKataExporter\Schemas
 */
final class ChallengeSchema implements SchemaInterface
{
    /**
     * Get the schema used for validation
     *
     * @return Schema
     */
    public function schema(): Schema
    {
        return Schema::parse([
            "id:string",
            "name:string",
            "slug:string",
            "category:string",
            "publishedAt:dt",
            "approvedAt:dt",
            "languages:array" => "string",
            "url:string",
            "rank:object" => [
                "id:int",
                "name:string",
                "color:string",
            ],
            "createdBy:object" => [
                "username:string",
                "url:string"
            ],
            "approvedBy:object" => [
                "username:string",
                "url:string"
            ],
            "description:string",
            "totalAttempts:int",
            "totalCompleted:int",
            "totalStars:int",
            "tags:array" => "string"
        ]);
    }

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
}