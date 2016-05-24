<?php

namespace Pyrin\Core\Variable;

/**
 *
 * @author Mirrikat45
 */
interface DataInterface {
  public function add($variable, $value);
  public function remove($variable);
  public function getArray();
  public function getJSON();
  public function getXML();
}
