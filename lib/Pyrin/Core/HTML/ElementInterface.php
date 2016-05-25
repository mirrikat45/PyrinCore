<?php

namespace Pyrin\Core\HTML;

/**
 * Defines the interface for HTML Elements
 */
interface ElementInterface {
  public function prepend($type, $properties = array());
  public function append($type, $properties = array());
  public function data($attribute, $value = NULL);
  public function find($search);
  public function remove();
  public function parent();
  public function children();
  
}
