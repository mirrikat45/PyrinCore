<?php

namespace Pyrin\Core\Variable;

interface VariableInterface {
  public function set($value);
  public function value();
  public function __toString();
}