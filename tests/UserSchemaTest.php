<?php

declare(strict_types=1);

namespace CodewarsApiClient\Tests;

use CodewarsApiClient\Interfaces\SchemaInterface;
use CodewarsApiClient\Schemas\UserSchema;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UserSchemaTest extends TestCase
{
    private SchemaInterface $schema;

    protected function setUp(): void
    {
        $this->schema = new UserSchema();
    }

    public function testValidateReturnsFalseWithEmptyArrayGiven(): void
    {
        $this->assertEquals(false, $this->schema->validate([]));
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $this->assertEquals(false, $this->schema->validate(['username' => $_ENV['CODEWARS_VALID_USERNAME']]));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $this->assertEquals(true, $this->schema->validate([
            'username' => $_ENV['CODEWARS_VALID_USERNAME'],
            'name' => 'name',
            'honor' => 1,
            'clan' => 'clan',
            'leaderboardPosition' => 1,
            'skills' => ['one', 'two'],
            'ranks' => [
                'overall' => [
                    'rank' => 1,
                    'name' => 'name',
                    'color' => 'color',
                    'score' => 1,
                ],
                'languages' => [
                    'javascript' => [
                        'rank' => 1,
                        'name' => 'name',
                        'color' => 'color',
                        'score' => 1,
                    ],
                ],
            ],
            'codeChallenges' => [
                'totalAuthored' => 1,
                'totalCompleted' => 1,
            ],
        ]));
    }
}
