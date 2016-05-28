<?php

namespace Pyrin\Core\Render;

/**
 *
 * @author Mirrikat45
 */
interface DocumentInterface {
  public function render();
  public function headers();
  public function setHeader($header, $value);
}
