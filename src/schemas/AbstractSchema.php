<?php

declare(strict_types=1);

namespace CodewarsApiClient\Schemas;

use CodewarsApiClient\Interfaces\SchemaInterface;
use Nette\Schema\Processor;
use Nette\Schema\Schema;
use Nette\Schema\ValidationException;

abstract class AbstractSchema implements SchemaInterface
{
    /**
     * @param array<mixed> $data
     */
    public function validate(array $data): bool
    {
        try {
            (new Processor())->process($this->schema(), $data);

            return true;
        } catch (ValidationException $e) {
            return false;
        }
    }

    abstract protected function schema(): Schema;
}
