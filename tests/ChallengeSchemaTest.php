<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Interfaces\SchemaInterface;
use CodewarsKataExporter\Schemas\ChallengeSchema;
use PHPUnit\Framework\TestCase;

final class ChallengeSchemaTest extends TestCase
{
    private SchemaInterface $schema;

    protected function setUp(): void
    {
        $this->schema = new ChallengeSchema();
    }

    public function testValidateReturnsFalseWithEmptyArrayGiven(): void
    {
        $this->assertEquals(false, $this->schema->validate([]));
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $this->assertEquals(false, $this->schema->validate(['id' => base64_encode('id')]));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $this->assertEquals(true, $this->schema->validate([
            'id' => base64_encode('id'),
            'name' => 'challenge',
            'slug' => 'some-thing',
            'category' => 'test',
            'publishedAt' => date('d/m/Y h:i:s a', time()),
            'approvedAt' => date('d/m/Y h:i:s a', time()),
            'languages' => ['one', 'two'],
            'url' => 'https://example.com',
            'rank' => [
                'id' => 1,
                'name' => 'rank',
                'color' => 'color',
            ],
            'createdBy' => [
                'username' => $_ENV['CODEWARS_VALID_USERNAME'],
                'url' => 'https://example.com',
            ],
            'approvedBy' => [
                'username' => $_ENV['CODEWARS_VALID_USERNAME'],
                'url' => 'https://example.com',
            ],
            'description' => 'description',
            'totalAttempts' => 1,
            'totalCompleted' => 1,
            'totalStars' => 2,
            'tags' => ['one', 'two'],
        ]));
    }
}
