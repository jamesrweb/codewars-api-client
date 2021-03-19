<?php

declare(strict_types=1);

namespace CodewarsApiClient\Tests;

use CodewarsApiClient\Interfaces\SchemaInterface;
use CodewarsApiClient\Schemas\CompletedChallengesSchema;
use PHPUnit\Framework\TestCase;

final class CompletedChallengesSchemaTest extends TestCase
{
    private SchemaInterface $schema;

    protected function setUp(): void
    {
        $this->schema = new CompletedChallengesSchema();
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
                'slug' => 'some-thing',
                'completedAt' => date(DATE_ISO8601),
                'completedLanguages' => ['one', 'two'],
            ],
        ]));
    }
}
