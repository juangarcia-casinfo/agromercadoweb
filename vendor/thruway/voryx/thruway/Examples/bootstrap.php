<?php

/**
 * Find the auto loader file
 */
$files = [
    __DIR__ . '/../../../../thruway/autoload.php',
    __DIR__ . '/../../../thruway/autoload.php',
    __DIR__ . '/../../thruway/autoload.php',
    __DIR__ . '/../thruway/autoload.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        require $file;
        break;
    }
}

