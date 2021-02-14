<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Interfaces\SchemaInterface;
use CodewarsKataExporter\Schemas\UserSchema;
use PHPUnit\Framework\TestCase;

final class UserSchemaTest extends TestCase
{
    private SchemaInterface $schema;

    protected function setUp(): void
    {
        $this->schema = new UserSchema();
    }

    public function testValidateReturnsFalseWithEmptyArrayGiven(): void
    {
        $data = [];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $data = ['username' => $_ENV['CODEWARS_VALID_USERNAME']];
        $this->assertEquals(false, $this->schema->validate($data));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $data = [
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
        ];
        $this->assertEquals(true, $this->schema->validate($data));
    }
}
