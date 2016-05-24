<?php

namespace Pyrin\Core\Variable;

use Pyrin\Core\Variable\VariableInterface;

/**
 * Attributes act as variables with object methods.
 */
class Attribute implements VariableInterface {
  protected $value;
  
  /**
   * Creates a new Attribute.
   * Attributes are simple implimented variables with setters and getters.
   * @param mixed $value The value of this attribute.
   */
  public function __construct($value = NULL) {
    $this->set($value);
  }
  
  /**
   * Sets the current value.
   * @param mixed $value The value to set to this attribute.
   */
  public function set($value) {
    $this->value = $value;
  }
  
  /**
   * Retreives the value.
   * @return mixed The current value of this attribute.
   */
  public function value() {
    return $this->value;
  }

  /**
   * Converts the attribute into it's string value.
   * @return string The string representation of this attribute.
   */
  public function __toString() {
    return $this->value;
  }
}