<?php

declare(strict_types=1);

use Madewithlove\PhpCsFixer\Config;

$base = dirname(__DIR__, 2);
$folders = ["{$base}/src", "{$base}/tests", "{$base}/config"];
$target = '8.0';

return Config::fromFolders($folders, $target)
    ->enablePhpunitRules()
    ->mergeRules([
        'declare_strict_types' => true,
        'date_time_immutable' => true,
        'final_public_method_for_abstract_class' => true,
        'ordered_class_elements' => true,
        'php_unit_method_casing' => true,
        'php_unit_size_class' => true,
        'php_unit_strict' => true,
        'php_unit_test_annotation' => true,
        'phpdoc_to_param_type' => true,
        'protected_to_private' => true,
        'random_api_migration' => true,
        'static_lambda' => true,
        'trailing_comma_in_multiline_array' => false,
    ])
    ->setUsingCache(false);
