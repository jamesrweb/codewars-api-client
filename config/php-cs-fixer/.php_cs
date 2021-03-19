<?php

declare(strict_types=1);

use Madewithlove\PhpCsFixer\Config;

$base = dirname(__DIR__, 2);
$source = $base . "/src";
$tests = $base . "/tests";
$target_php_version = "8.0";

return Config::fromFolders([$source, $tests], $target_php_version);