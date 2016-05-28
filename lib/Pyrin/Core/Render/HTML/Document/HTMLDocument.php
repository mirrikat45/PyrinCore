<?php

namespace Pyrin\Core\Render\HTML\Document;

use Pyrin\Core\Render\HTML\HTML;
use Pyrin\Core\Render\DocumentInterface;
use Pyrin\Core\Render\RenderInterface;
use Pyrin\Core\Render\Headers;
use Pyrin\Core\Render\HTML\Element;

/**
 * Creates a basic html document.
 */
class HTMLDocument extends HTML implements DocumentInterface, RenderInterface {
  
  protected $doctype;
  protected $headers;
  
  public function __construct($doctype) {
    $this->tag = 'html';
    $this->inline = false;
    $this->doctype = $doctype;
    $this->headers = new Headers();
    $this->setHeader('Content-Type', 'text/html');
    
    // Add the required HTML components
    $this->_append('head')->append('title');
    $this->append('body');
  }
  
  public function setHeader($header, $value) {
    $this->headers->{$header} = $value;
  }
  
  public function __toString() {
    return '<!DOCTYPE ' . $this->doctype . '>' .  $this->html();
  }
  
  public function render() {
    $this->headers->render();
    echo '<!DOCTYPE ' . $this->doctype . '>' . $this->html();
  }
  
  public function headers() {
    return $this->headers->getArray();
  }
  
  
  // HTML FUNCTIONS //
  public function body() {
    return $this->find('body');
  }
  
  public function head() {
    return $this->find('head');
  }
}
