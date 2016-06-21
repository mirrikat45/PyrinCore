<?php

// Require the SPL Autoloader to automagically load classes and interfaces.
// See: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
require('includes/autoloader.php');
$pyrinLoader = new PyrinAutoLoader('Pyrin', __DIR__ . '/lib');
$pyrinLoader->register();


define('PYRIN_DIR', __DIR__);

/* PYRIN CONSTANTS */
//$pyrin_constants = array(
//  'LOG_STATUS' => 0,
//  'LOG_NOTICE' => 1,
//  'LOG_WARNING' => 2,
//  'LOG_ERROR' => 3,
//  'LOG_ALERT' => 4,
//);
//
//foreach ( $pyrin_constants as $name => $value ) {
//  if ( !defined($name) ) {
//    define($name, $value);
//  }
//}