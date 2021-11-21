<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ResponseFactory;
use Tests\Fixtures\ResponseFactoryInterface;
use Tests\Schemas\ChallengeSchema;
use Tests\Schemas\SchemaInterface;

/**
 * @internal
 *
 * @small
 */
final class ChallengeSchemaTest extends TestCase
{
    private SchemaInterface $schema;
    private ResponseFactoryInterface $responses;

    protected function setUp(): void
    {
        $this->schema = new ChallengeSchema();
        $this->responses = new ResponseFactory();
    }

    public function testValidateReturnsFalseWithEmptyArrayGiven(): void
    {
        $challenge = $this->responses->empty();

        $this->assertFalse($this->schema->validate($challenge));
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $challenge = $this->responses->partial_challenge();

        $this->assertFalse($this->schema->validate($challenge));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $challenge = $this->responses->valid_challenge();

        $this->assertTrue($this->schema->validate($challenge));
    }
}
