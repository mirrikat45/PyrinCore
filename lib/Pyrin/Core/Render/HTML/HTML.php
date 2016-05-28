<?php

namespace Pyrin\Core\Render\HTML;

use Pyrin\Core\Render\HTML\Element;

class HTML extends Element {
  
  public function __construct($html, $attributes = array()) {
    // TOD: This function should parse through html.
    parent::__construct($html, $attributes);
  }

  public function p($text, $attributes = array()) {
    $p = new Element('p', $attributes);
    $p->text = $text;
    $this->append($p);
    return $this;
  }
  
  public function img($src, $attributes = array()) {
    $img = (new Element('img', $attributes))->attr('src', $src);
    $this->append($img);
    return $this;
  }
  
  public function strong($text, $attributes = array()) {
    $strong = (new Element('strong', $attributes));
    $strong->text = $text;
    $this->append($strong);
    return $this;
  }
}
