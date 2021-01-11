<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

use Garden\Schema\Schema;

/**
 * Interface SchemaInterface
 * @package CodewarsKataExporter\Schemas
 */
interface SchemaInterface
{
    public function schema(): Schema;

    public function validate(array $data): bool;
}