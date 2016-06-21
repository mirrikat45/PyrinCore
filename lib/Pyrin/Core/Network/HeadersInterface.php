<?php

namespace Pyrin\Core\Network;

/**
 *
 * @author Mirrikat45
 */
interface HeadersInterface {
  /**
   * Adds a header attribute to the request.
   * @param string $property The name of the attribute or variable to store.
   * @param mixed $value The value to store in the attribute.
   * @return \URLRequest
   */
  public function addHeader($property, $value);
  
  public function getHeaders();
}
