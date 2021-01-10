<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Schemas;

/**
 * Interface SchemaInterface
 * @package CodewarsKataExporter\Schemas
 */
interface SchemaInterface
{
    public function validate(): bool;
}