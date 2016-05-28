<?php

namespace Pyrin\Core\Render;

use Pyrin\Core\Variable\Data;
use Pyrin\Core\Render\RenderInterface;

class Headers extends Data implements RenderInterface {
  public function __toString() {
    return print_r($this->getArray(), true);
  }
  
  public function render() {
    foreach ( $this->getArray() as $header => $value ) {
      header(sprintf('%s: %s', $header, $value));
    }
  }
}
