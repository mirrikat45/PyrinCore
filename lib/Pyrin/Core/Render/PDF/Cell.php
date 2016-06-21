<?php

namespace Pyrin\Core\Render\PDF;

use Pyrin\Core\Render\PDF\PDF;
use Pyrin\Core\Variable\Matrix;
use Pyrin\Core\Render\PDF\Color;

class Cell {
  /**
   * @var string $html Html contents.
   * @var string $align Text Alignment.
   * @var Pyrin\Core\Variable\Matrix $matrix The 2D Matrix. 
   */
  protected $matrix;
  protected $text = '';
  protected $align = 'L';
  protected $fill = FALSE;
  protected $link = '';
  protected $valign = 'M';
  
  protected $padding;
  protected $margin;
  protected $style;
  
  /**
   * Creates a new PDF HTML CELL
   * @param bool $style Rather or not this cell acts as a style cell.
   */
  public function __construct($style = FALSE) {
    $this->matrix = new Matrix('', '', '', '');
    $this->style = $style;
    
    // Store existing Padding
    $this->padding = $this->pdf()->getCellPaddings();
    $this->margin = $this->pdf()->getCellMargins();
  }
  
   public function text($text) {
    $this->text = $text;
    return $this;
  }
  
  public function size($width, $height) {
    $this->matrix->width = $width;
    $this->matrix->height = $height;
    return $this;
  }
  
  public function position($x, $y, $addMargins = TRUE) {
    if ( $addMargins ) {
      $this->matrix->x = $x + $this->pdf()->getMargin('left');
      $this->matrix->y = $y + $this->pdf()->getMargin('top');
    } else {
      $this->matrix->x = $x;
      $this->matrix->y = $y;
    }
    
    return $this;
  }
  
  public function margin($top = 0, $right = '', $bottom = '', $left = '') {
    $this->pdf()->setCellMargins($left, $top, $right, $bottom);
    return $this;
  }
  
  public function padding($top = 0, $right = '', $bottom = '', $left = '') {
    $this->pdf()->setCellPaddings($left, $top, $right, $bottom);
    return $this;
  }
  
  public function align($align = "L") {
    $this->align = $align;
    return $this;
  }
  
  public function valign($valign = "M") {
    $this->valign = $valign;
    return $this;
  }
  
  public function border() {
    
  }
  
  public function lineHeight($height) {
    $this->pdf()->setCellHeightRatio($height / $this->pdf()->getFontSize());
    return $this;
  }
  
  public function fill($color) {
    $color = Color::HEX($color);
    $this->pdf()->SetFillColorArray($color->value(), FALSE);
    $this->fill = true;
    return $this;
  }
  
  public function color($color) {
    $color = Color::HEX($color);
    $this->pdf()->SetTextColorArray($color->value());
    return $this;
  }
  
  public function font($size = 14, $style = '', $family = 'helvetica', $fontfile = '') {
    $this->pdf()->SetFont($family, $style, $size, $fontfile, FALSE);
    return $this;
  }
  
  /**
   * Writes the final output to the screen.
   */
  public function write() {
    // Set the X/Y of the pointer here.
    $this->pdf()->SetAbsX($this->matrix->x);
    $this->pdf()->SetAbsY($this->matrix->y);

    // Draw a Text Cell
    $this->pdf()->Cell($this->matrix->width, $this->matrix->height, $this->text, 0, 0, $this->align, $this->fill, $this->link, 0, FALSE, 'T', $this->valign);
    
    // Reset The Default Cell Properties.
    if ( !$this->style ) $this->reset();
    
    return $this;
  }
  
  protected function reset() {
    // Reset Line Height
    $this->pdf()->setCellHeightRatio(1.25);
    
    // Reset Padding
    $this->pdf()->setCellPaddings($this->padding['L'], $this->padding['T'], $this->padding['R'], $this->padding['B']);
    $this->pdf()->setCellMargins($this->margin['L'], $this->margin['T'], $this->margin['R'], $this->margin['B']);
    
    // Reset Color
    $this->color($this->pdf()->default_color);
  }
  
  public function __set($name, $value) {
    $matrix_variables = array('x', 'y', 'width', 'height');
    if ( in_array($name, $matrix_variables) ) {
      $this->matrix->{$name} = $value;
    }
  }
  
  /**
   * Gets the current PDF
   * @return Pyrin\Core\Render\PDF\PDF
   */
  protected function pdf() {
    return PDF::getPDF();
  }
  
  
  /**
   * Moves this cell to the left.
   * @param int $x The amount to move.
   */
  public function left($x) {
    $this->matrix->x += $x;
    return $this;
  }
  
  /**
   * Moves this cell to the right.
   * @param int $x The amount to move.
   */
  public function right($x) {
    $this->matrix->x -= $x;
    return $this;
  }
  
  /**
   * Moves this cell down.
   * @param int $y The amount to move.
   */
  public function top($y) {
    $this->matrix->y += $y;
    return $this;
  }
}
