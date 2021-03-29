<?php

declare(strict_types=1);

use Madewithlove\PhpCsFixer\Config;

$base = dirname(__DIR__, 2);

return Config::fromFolders(["{$base}/src", "{$base}/tests"], "8.0")->enablePhpunitRules();