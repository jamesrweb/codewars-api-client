<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\ResponseFactory;
use Tests\Fixtures\ResponseFactoryInterface;
use Tests\Schemas\SchemaInterface;
use Tests\Schemas\UserSchema;

/**
 * @internal
 */
final class UserSchemaTest extends TestCase
{
    private SchemaInterface $schema;
    private ResponseFactoryInterface $responses;

    protected function setUp(): void
    {
        $this->schema = new UserSchema();
        $this->responses = new ResponseFactory();
    }

    public function testValidateReturnsFalseWithEmptyArrayGiven(): void
    {
        $user = $this->responses->empty();
        $this->assertEquals(false, $this->schema->validate($user));
    }

    public function testValidateReturnsFalseWithMissingFields(): void
    {
        $user = $this->responses->partial_user();
        $this->assertEquals(false, $this->schema->validate($user));
    }

    public function testValidateReturnsTrueWithAllFieldsGiven(): void
    {
        $user = $this->responses->valid_user();
        $this->assertEquals(true, $this->schema->validate($user));
    }
}
