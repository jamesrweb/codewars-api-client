<?php

declare(strict_types=1);

namespace CodewarsApiClient\Tests;

use CodewarsApiClient\Tests\Fixtures\ResponseFactory;
use CodewarsApiClient\Tests\Fixtures\ResponseFactoryInterface;
use CodewarsApiClient\Tests\Schemas\CompletedChallengesSchema;
use CodewarsApiClient\Tests\Schemas\SchemaInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
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
        $this->assertEquals(false, $this->schema->validate($completed));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $completed = $this->responses->valid_completed_challenge();
        $this->assertEquals(true, $this->schema->validate($completed));
    }
}
