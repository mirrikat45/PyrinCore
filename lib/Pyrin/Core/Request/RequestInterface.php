<?php

namespace Pyrin\Core\Request\WebRequest;

/**
 *
 * @author Mirrikat45
 */
interface RequestInterface {
  public function __toString();
  public function addData($property, $value);
  public function addHeader($property, $value);
  public function execute();
  public function getJSON();
}
