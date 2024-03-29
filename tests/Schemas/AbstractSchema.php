<?php

declare(strict_types=1);

namespace Tests\Schemas;

use Nette\Schema\Processor;
use Nette\Schema\Schema;
use Nette\Schema\ValidationException;

interface SchemaInterface
{
    /**
     * Validate provided data against the schema.
     *
     * @param array<mixed> $data
     */
    public function validate(array $data): bool;
}

abstract class AbstractSchema implements SchemaInterface
{
    /**
     * {@inheritdoc}
     */
    final public function validate(array $data): bool
    {
        try {
            $processor = new Processor();
            $processor->process($this->schema(), $data);

            return true;
        } catch (ValidationException $e) {
            return false;
        }
    }

    /**
     * Returns the internal schema to be validated against.
     */
    abstract protected function schema(): Schema;
}
