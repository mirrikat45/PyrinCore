<?php

namespace Pyrin\Core\HTML;

/**
 * Defines the interface for HTML Elements
 */
interface ElementInterface {
  public function prepend($element);
  public function append($element);
  public function data($attribute, $value = NULL);
  public function find($search);
  public function remove();
  public function parent();
  public function children();
  public function html();
  public function render();
  public function prop();
}
