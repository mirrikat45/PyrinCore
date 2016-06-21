<?php

namespace Pyrin\Core\Render\PDF;

use Pyrin\Core\Variable\Data;

class Color {
  private $type;
  private $colors;
  
  public static function HEX($hex) {
    $colors = array();
    
    // Strip out the has symbol.
    $hex =  str_replace('#', '', $hex);
    
    // Support for 3 digit hex colors
    if (strlen($hex) == 3 ) {
      $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    // Split into 3 parts.
    $components = str_split($hex, 2);
    
    // Convert into 0-255 components.
    foreach ( $components as $value ) {
      $colors[] = hexdec($value);
    }
    
    // Add -1 for KEY
    //$colors[] = -1;
    
//    print_r($colors);
//    die();
    
    // Return the new Color
    return new Color($colors);
  }
  
  public static function RGB($red = 0, $green = 0, $blue = 0) {
    return new Color(array($red, $green, $blue, -1));
  }
  
  public static function CMYK($cyan = 0, $magenta = 0, $yellow = 0, $key = 0) {
    return new Color(array($cyan, $magenta, $yellow, $key));
  }

  public function __construct($colors) {
    $this->colors = $colors;
  }
  
  public function value() {
    return $this->colors;
  }
}
