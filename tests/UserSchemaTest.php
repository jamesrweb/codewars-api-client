<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Schemas\UserSchema;
use Garden\Schema\RefNotFoundException;
use Garden\Schema\Schema;
use PHPUnit\Framework\TestCase;

class UserSchemaTest extends TestCase
{
    private UserSchema $schema;

    public function setUp(): void
    {
        $this->schema = new UserSchema();
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
        $data = ["username" => $_ENV["CODEWARS_VALID_USERNAME"]];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    /**
     * @throws RefNotFoundException
     */
    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $data = [
            "username" => $_ENV["CODEWARS_VALID_USERNAME"],
            "name" => "name",
            "honor" => 1,
            "clan" => "clan",
            "leaderboardPosition" => 1,
            "skills" => ["one", "two"],
            "ranks" => [
                "overall" => [
                    "rank" => 1,
                    "name" => "name",
                    "color" => "color",
                    "score" => 1
                ],
                "languages" => [
                    "javascript" => [
                        "rank" => 1,
                        "name" => "name",
                        "color" => "color",
                        "score" => 1
                    ]
                ]
            ],
            "codeChallenges" => [
                "totalAuthored" => 1,
                "totalCompleted" => 1
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
