<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ResponseFactory;
use Tests\Fixtures\ResponseFactoryInterface;
use Tests\Schemas\CompletedChallengesSchema;
use Tests\Schemas\SchemaInterface;

/**
 * @internal
 *
 * @small
 */
final class CompletedChallengesSchemaTest extends TestCase
{
    private SchemaInterface $schema;
    private ResponseFactoryInterface $responses;

    protected function setUp(): void
    {
        $this->schema = new CompletedChallengesSchema();
        $this->responses = new ResponseFactory();
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $completed = $this->responses->partial_completed_challenge();

        $this->assertFalse($this->schema->validate($completed));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $completed = $this->responses->valid_completed_challenge();

        $this->assertTrue($this->schema->validate($completed));
    }
}
