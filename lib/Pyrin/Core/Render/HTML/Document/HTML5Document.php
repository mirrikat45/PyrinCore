<?php

namespace Pyrin\Core\Render\HTML\Document;

use Pyrin\Core\Render\HTML\Document\HTMLDocument;

class HTML5Document extends HTMLDocument {
  public function __construct() {
    parent::__construct('html');
  }
}
