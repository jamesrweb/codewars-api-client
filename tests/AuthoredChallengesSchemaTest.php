<?php

declare(strict_types=1);

namespace CodewarsApiClient\Tests;

use CodewarsApiClient\Tests\Fixtures\ResponseFactory;
use CodewarsApiClient\Tests\Fixtures\ResponseFactoryInterface;
use CodewarsApiClient\Tests\Schemas\AuthoredChallengesSchema;
use CodewarsApiClient\Tests\Schemas\SchemaInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
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
        $this->assertEquals(false, $this->schema->validate($authored));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $authored = $this->responses->valid_authored_challenge();
        $this->assertEquals(true, $this->schema->validate($authored));
    }
}
