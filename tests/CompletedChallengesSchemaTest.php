<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Schemas\CompletedChallengesSchema;
use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;
use PHPUnit\Framework\TestCase;

/**
 * Class CompletedChallengesSchemaTest
 * @package CodewarsKataExporter\Tests
 */
class CompletedChallengesSchemaTest extends TestCase
{
    private CompletedChallengesSchema $schema;

    public function setUp(): void
    {
        $this->schema = new CompletedChallengesSchema();
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
        $data = ["data" => []];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $data = [
            "totalPages" => 1,
            "totalItems" => 1,
            "data" => [
                [
                    "id" => base64_encode("id"),
                    "name" => "name",
                    "slug" => "some-thing",
                    "completedAt" => date("d/m/Y h:i:s a", time()),
                    "completedLanguages" => ["one", "two"]
                ]
            ]
        ];
        $this->assertEquals(true, $this->schema->validate($data));
    }

    public function testGetSchema(): void
    {
        $schema = $this->schema->schema();
        $this->assertInstanceOf(Schema::class, $schema);
    }
}
