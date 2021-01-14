<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Schemas\ChallengeSchema;
use Garden\Schema\RefNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class ChallengeSchemaTest
 * @package CodewarsKataExporter\Tests
 */
final class ChallengeSchemaTest extends TestCase
{
    private ChallengeSchema $schema;

    public function setUp(): void
    {
        $this->schema = new ChallengeSchema();
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsFalseWithEmptyArrayGiven(): void
    {
        $data = [];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $data = ["id" => base64_encode("id")];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $data = [
            "id" => base64_encode("id"),
            "name" => "challenge",
            "slug" => "some-thing",
            "category" => "test",
            "publishedAt" => date("d/m/Y h:i:s a", time()),
            "approvedAt" => date("d/m/Y h:i:s a", time()),
            "languages" => ["one", "two"],
            "url" => "https://example.com",
            "rank" => [
                "id" => 1,
                "name" => "rank",
                "color" => "color"
            ],
            "createdBy" => [
                "username" => $_ENV["CODEWARS_VALID_USERNAME"],
                "url" => "https://example.com"
            ],
            "approvedBy" => [
                "username" => $_ENV["CODEWARS_VALID_USERNAME"],
                "url" => "https://example.com"
            ],
            "description" => "description",
            "totalAttempts" => 1,
            "totalCompleted" => 1,
            "totalStars" => 2,
            "tags" => ["one", "two"]
        ];
        $this->assertEquals(true, $this->schema->validate($data));
    }
}
