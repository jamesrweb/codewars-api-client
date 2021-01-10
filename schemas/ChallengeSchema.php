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
    private array $data;

    /**
     * ChallengeSchema constructor
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
     * @return bool
     * @throws RefNotFoundException
     */
    public function validate(): bool
    {
        return $this->getSchema()->isValid($this->data);
    }
}