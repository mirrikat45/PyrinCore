<?php

// Require the SPL Autoloader to automagically load classes and interfaces.
// See: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
require('includes/autoloader.php');
$pyrinLoader = new PyrinAutoLoader('Pyrin', __DIR__ . '/lib');
$pyrinLoader->register();