<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Interfaces\SchemaInterface;
use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use PHPUnit\Framework\TestCase;

final class AuthoredChallengesSchemaTest extends TestCase
{
    private SchemaInterface $schema;

    protected function setUp(): void
    {
        $this->schema = new AuthoredChallengesSchema();
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $this->assertEquals(false, $this->schema->validate([['id' => base64_encode('id')]]));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $this->assertEquals(true, $this->schema->validate([
            [
                'id' => base64_encode('id'),
                'name' => 'name',
                'description' => 'description',
                'rank' => 1,
                'rankName' => 'rank',
                'tags' => ['one', 'two'],
                'languages' => ['one', 'two'],
            ],
        ]));
    }
}
