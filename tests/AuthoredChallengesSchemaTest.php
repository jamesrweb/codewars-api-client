<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ResponseFactory;
use Tests\Fixtures\ResponseFactoryInterface;
use Tests\Schemas\AuthoredChallengesSchema;
use Tests\Schemas\SchemaInterface;

/**
 * @internal
 *
 * @small
 */
final class AuthoredChallengesSchemaTest extends TestCase
{
    private SchemaInterface $schema;
    private ResponseFactoryInterface $responses;

    protected function setUp(): void
    {
        $this->schema = new AuthoredChallengesSchema();
        $this->responses = new ResponseFactory();
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $authored = $this->responses->partial_authored_challenge();

        $this->assertFalse($this->schema->validate($authored));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $authored = $this->responses->valid_authored_challenge();

        $this->assertTrue($this->schema->validate($authored));
    }
}
