<?php

declare(strict_types=1);

namespace CodewarsApiClient\Helpers;

function ISO8601_pattern(): string
{
    return '^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}(\\.[0-9]+)?([zZ]|([\\+-])([01]\\d|2[0-3]):?([0-5]\\d)?)?$';
}
