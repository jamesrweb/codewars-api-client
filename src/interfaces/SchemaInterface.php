<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Interfaces;

use Garden\Schema\Schema;

/**
 * Interface SchemaInterface
 * @package CodewarsKataExporter\Interfaces
 */
interface SchemaInterface
{
    public function schema(): Schema;

    public function validate(array $data): bool;
}