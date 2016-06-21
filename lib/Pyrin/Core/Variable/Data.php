<?php

namespace Pyrin\Core\Variable;

use Pyrin\Core\Variable\DataInterface;
class Data implements DataInterface {
  private $data = array();
  
  public function __construct($arr = NULL) {
    if ( $this->is_data($arr) ) {
      $this->value($arr);
    }
  }
  
  private function is_data($variable) {
    return is_array($variable) || is_a($variable, 'Pyrin\Core\Variable\Data');
  }
  
  /**
   * Set an attribute's value.
   * @param string $name The name of the attribute.
   * @param mixed $value The value of that attribute.
   * @return \Pyrin\Core\Variable\Data
   */
  public function __set($name, $value) {
    $this->data[$name] = $value;
  }
  
  /**
   * Remove's an attribute.
   * @param type $name The name of the attribute.
   */
  public function __unset($name) {
    unset($this->data[$name]);
  }
  
  /**
   * Determines if an attribute is set or not.
   * @param type $name The name of the attribute.
   */
  public function __isset($name) {
    return isset($this->data[$name]);
  }
  
  /**
   * Gets the length of this data's properties.
   * @return int The number of attributes contained within this data object.
   */
  public function length() {
    return count($this->data);
  }
  
  /**
   * Retreives an attribute's value.
   * @param string $name The name of the attribute.
   * @return mixed The attribute's value.
   */
  public function __get($name) {
    // Add support for .length
    if ( array_key_exists($name, $this->data) ) {
      return $this->data[$name];
    } else {
      $trace = debug_backtrace();
      //trigger_error('Access to undefined property via __get(): ' . $name . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'], E_USER_NOTICE);
      return null;
    }
  }
  
  /**
   * Returns this Data Object as an array.
   * @return array The array representing this data object.
   */
  public function getArray() {
    return $this->data;
  }
  
  public function getJSON() {
    return json_encode($this->getArray());
  }
  
  /**
   * Returns this Data Object as an array. Or sets an array value for this object.
   * See: getArray();
   */
  public function value($arr = NULL) {
    
    
    
    if ( is_array($arr) ) {
      $this->data = array();
      foreach ( $arr as $property => $value ) {
        $this->data[$property] = $value;
      }
    } elseif ( $this->is_data($arr) ) {
      foreach ( $arr->value() as $property => $value ) {
        $this->data[$property] = $value;
      }
    }
    
    return $this->data;
  }
  
  /**
   * Merge Values into this Data Object
   * @param type $arr
   */
  public function merge($arr = array(), $overwrite = false) {
    if ( $overwrite === TRUE ) {
      $this->data = array_merge($this->data, $arr);
    } else {
      $this->data = array_merge($arr, $this->data);
    }
    return $this;
  }
}