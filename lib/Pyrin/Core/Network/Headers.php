<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Variable\Data;

class Headers extends Data {
  public function __toString() {
    return $this->value();
  }
  
  public function value($arr = NULL) {
    if ( isset($arr) ) {
      parent::value($arr);
    }
    $value = '';
    $headers = $this->getArray();
    foreach ( $headers as $header => $setting ) {
     $value .= sprintf("%s: %s\r\n", $header, $setting);
    }
    return $value;
  }
}
