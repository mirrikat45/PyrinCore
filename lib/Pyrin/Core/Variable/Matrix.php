<?php

namespace Pyrin\Core\Variable;
use Pyrin\Core\Variable\Data;

/**
 * A Variable object for controlling 2 dimensional structures.
 */
class Matrix extends Data {
  /**
   * @var number $width Width
   * @var number $height Height
   * @var number $x X
   * @var number $y Y
   * @var number $rotation Rotation in Degrees.
   */
  
  public function __construct($width = 0, $height = 0, $x = 0, $y = 0) {
    $this->x = $x;
    $this->y = $y;
    $this->width = $width;
    $this->height = $height;
  }
  
//  public function __get($name) {
//    $value = parent::__get($name) or 0;
//    if (is_numeric($value) ) {
//    return round($value, 0);
//  }
}
