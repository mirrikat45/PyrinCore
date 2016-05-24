<?php

namespace Pyrin\Core\Variable;

use Pyrin\Core\Variable\Attribute;
use Pyrin\Core\Variable\VariableInterface;

class Data implements DataInterface {
  
  /**
   * Add a new attribute to this data.
   * @param string $property The name of the property to store a value in.
   * @param mixed $value The value to store.
   * @return \Pyrin\Core\Variable\Data
   */
  public function add($property, $value) {
    $this->{$property} = new Attribute($value);
    return $this;
  }
  
  /**
   * Removes a property from this data.
   * @param string $property The name of the property to remove.
   * @return \Pyrin\Core\Variable\Data
   */
  public function remove($property) {
    unset($this->{$property});
    return $this;
  }
  
  /**
   * Returns this Data Object as an array.
   * @return array The array representing this data object.
   */
  public function getArray() {
    $array = array();
    foreach ( $this as $property => $value ) {
      $array[$property] = $value->value();
    }
    return $array;
  }
  
  /**
   * Returns this Data Object as a JSON object.
   */
  public function getJSON() {
    return json_encode($this->getArray());
  }
  
  /**
   * Returns this Data Object as an XML object.
   */
  public function getXML() {
    // TOD: Add this feature;
  }
  
//  private function _convert_array($object) {
//    $properties = is_object($object) ? $this->_convert_array($object) : $object;
//    foreach ( $properties as $property => $value ) {
//      $value = (is_array($value)) || is_object($value) ? $this->_convert_array($value) : $value;
//      $properties[$property] = $value;
//    }
//    return $properties;
//  }
}
