<?php

namespace Pyrin\Core\Variable;

/**
 *
 * @author Mirrikat45
 */
interface DataInterface {
  public function __set($name, $value);
  public function __get($name);
  public function __unset($name);
  public function __isset($name);
  public function getArray();
  public function value();
}
