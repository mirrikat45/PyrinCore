<?php

namespace Pyrin\Core\Render\PDF;

use Pyrin\Core\Render\PDF\Cell;


class HTMLCell extends Cell {
  public function html($html) {
    return $this->text($html);
  }
  
  /**
   * Writes the final output to the screen.
   */
  public function write($reset = TRUE) {
    $this->pdf()->writeHTMLCell($this->matrix->width, $this->matrix->height, $this->matrix->x, $this->matrix->y, $this->text, 0, 0, $this->fill, true, $this->align, FALSE);
    
    // Reset The Default Cell Properties.
    if ( !$this->style ) $this->reset();
    
    return $this;
  }
}
