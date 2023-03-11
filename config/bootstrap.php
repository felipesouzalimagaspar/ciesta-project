<?php
declare(strict_types=1);
foreach([
    "memory_limit" => "-1",
    "default_mimetype" => "application/json",
    "default_charset" => "UTF-8",
    "user_agent" => "Ciesta",
    "max_execution_time" => "-1",
    "display_errors" => true,
    "xdebug.log_level" => 10
    ] as $PHP_INI_PROPERTY_KEY => $PHP_INI_PROPERTY_VALUE
) ini_set($PHP_INI_PROPERTY_KEY, $PHP_INI_PROPERTY_VALUE);
    
require_once __DIR__ . '/../vendor/autoload.php';
$_ENV = array_merge($_ENV, \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/.config.yml')));
var_dump($_ENV);