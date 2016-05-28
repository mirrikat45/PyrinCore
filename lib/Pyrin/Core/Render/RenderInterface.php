<?php

namespace Pyrin\Core\Render;

interface RenderInterface {
  public function render();
  public function __toString();
}
