<?php

declare(strict_types=1);

requireAll(getcwd());

/**
 * Scan the api path, recursively including all PHP files
 */
function requireAll(string $dir): void
{
    // require all php files
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.php$/', $path)) {
            require_once $path;
        } elseif (is_dir($path)) {
            requireAll($path);
        }
    }
}
