<?php
namespace Pyrin\Core\Render\PDF;

use Pyrin\Core\Render\PDF\TCPDF\TCPDF;
use Pyrin\Core\Render\PDF\HTMLCell;
use Pyrin\Core\Render\PDF\Cell;
use Pyrin\Core\Render\PDF\Color;

class PDF extends TCPDF {
  protected static $instance;
  public static $ALIGN_CENTER = 'C';
  public static $ALIGN_LEFT = 'L';
  public static $ALIGN_RIGHT = 'R';
  
  // Variables
  public $default_color = '#000';
  
  public function __construct() {
    parent::__construct('p', 'mm', 'LETTER', true, 'UTF-8', false);
    
    // Set Pyrin as the Core Creator
    $this->SetCreator('Pyrin-PDF');
    
    // Set this as the default Mono Spaced Font
    $this->SetDefaultMonospacedFont('courier');
  }
  
  /**
   * Gets the current PDF Instance.
   * @return \Pyrin\Core\Render\PDF\PDF
   */
  public static function getPDF() {
    if (null === static::$instance) {
        static::$instance = new static();
    }
    return static::$instance;
  }
  
  /**
   * Creates a new Cell
   * @return Pyrin\Core\Render\PDF\Cell
   */
  public function addCell() {
    return new Cell();
  }
  
  /**
   * Creates a new HTMLCell
   * @return Pyrin\Core\Render\PDF\HTMLCell
   */
  public function addHTMLCell() {
    return new HTMLCell();
  }
  
  /**
   * Gets a specific pdf margin.
   * @param string $margin the name of the margin requested.
   * @return int The current value of the requested margin.
   */
  public function getMargin($margin) {
    $margins = $this->getMargins();
    return $margins[$margin];
  }
  
  public function drawFilledRect($width, $height, $x, $y, $color, $addPageMargins = TRUE) {
    $this->addCell()
        ->size($width, $height, $addPageMargins)
        ->position($x, $y)
        ->fill($color)
        ->write();
    return $this;
  }
  
  public function drawRect($width, $height, $x, $y, $border_width = 0.2, $dash = 0, $color = '#333', $border = 'TBLR', $join = 'round') {
    
    //$this->SetLineStyle(array('width' => $border_width, 'cap' => 'butt', 'join' => $join, 'dash' => $dash, 'color' => Color::HEX($color)->value()));
    $this->SetAbsX($x);
    $this->SetAbsY($y);
    $this->Cell($width, $height, '', array($border => array('width' => $border_width, 'cap' => 'butt', 'join' => $join, 'dash' => $dash, 'color' => Color::HEX($color)->value())));
    
    return $this;
  }
  
  
}




