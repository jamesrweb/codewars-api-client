<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;
use PHPUnit\Framework\TestCase;

/**
 * Class AuthoredChallengesSchemaTest
 * @package CodewarsKataExporter\Tests
 */
final class AuthoredChallengesSchemaTest extends TestCase
{
    private AuthoredChallengesSchema $schema;

    public function setUp(): void
    {
        $this->schema = new AuthoredChallengesSchema();
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $data = [["id" => base64_encode("id")]];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $data = [
            [
                "id" => base64_encode("id"),
                "name" => "name",
                "description" => "description",
                "rank" => 1,
                "rankName" => "rank",
                "tags" => ["one", "two"],
                "languages" => ["one", "two"]
            ]
        ];
        $this->assertEquals(true, $this->schema->validate($data));
    }

    public function testSchema(): void
    {
        $schema = $this->schema->schema();
        $this->assertInstanceOf(Schema::class, $schema);
    }
}
