<?php

namespace Pyrin\Core\Render\HTML;

use Pyrin\Core\Variable\DataInterface;
use Pyrin\Core\Render\HTML\ElementInterface;

class Element implements DataInterface {
  /**
   * Rather or not this element is an inline element.
   * @var bool
   */
  protected $inline;
  
  /**
   * Rather or not this element uses a self closing tag.
   * @var bool
   */
  protected $void;
  
  /**
   * The HTML tag this elment represents.
   * TOD: Make tag a class and validate.
   * @var string 
   */
  protected $tag;
  
  /**
   * Text contents of element.
   * @var string
   */
  public $text;
  
  /**
   * Children elements attached to this element.
   * @var array 
   */
  protected $children = array();
  
  /**
   * This Elements properties/attributes
   * @var array
   */
  protected $attributes = array();
  
  private $INLINE_ELEMENTS = array(
    'b', 'big', 'i', 'small', 'tt', 'abbr', 'acronym', 
    'cite', 'code', 'dfn', 'em', 'kbd', 'strong', 'samp', 'time', 'var',
    'a', 'bdo', 'br', 'img', 'map', 'object', 'q', 'script', 'span', 'sup',
    'button', 'input', 'label', 'select', 'textarea',
  );
  
  private $VOID_ELEMENTS = array(
    'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 
    'link', 'meta', 'param', 'source',
  );
  
  public function __construct($tag, $attributes = array()) {
    // Set the element tag
    $this->tag = $tag;
    
    // Set rather or not this is inline.
    $this->inline = in_array($tag, $this->INLINE_ELEMENTS);
    
    // Finally, set rather or not this tag closes itself.
    $this->void = in_array($tag, $this->VOID_ELEMENTS);
    
    // Set any selected attributes
    $this->attributes = $attributes;
  }
  
  /**
   * Set an property's value.
   * @param string $name The name of the attribute.
   * @param mixed $value The value of that property.
   * @return \Pyrin\Core\Variable\Data
   */
  public function __set($name, $value) {
    $this->attributes[$name] = $value;
  }
  
  /**
   * Retreives an property's value.
   * @param string $name The name of the attribute.
   * @return mixed The property's value.
   */
  public function __get($name) {
    if ( array_key_exists($name, $this->attributes) ) {
      return $this->attributes[$name];
    } else {
      $trace = debug_backtrace();
      //trigger_error('Access to undefined property via __get(): ' . $name . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'], E_USER_NOTICE);
      return null;
    }
  }
  
  /**
   * Remove's an attribute.
   * @param type $name The name of the attribute.
   */
  public function __unset($name) {
     unset($this->attributes[$name]);
  }
  
  /**
   * Determines if an attribute is set or not.
   * @param type $name The name of the attribute.
   */
  public function __isset($name) {
    return isset($this->attributes[$name]);
  }
  
  // Todo: What should this do?
  public function getArray() {
      return $this->children;
  }
  
  /**
   * Returns rather or not this element is inline.
   * @return bool
   */
  public function isInline() {
    return $this->inline;
  }
  
  /**
   * Returns rather or not this element is a block.
   * @return bool
   */
  public function isBlock() {
    return !$this->inline;
  }
  
  /**
   * Converts this element into a block element.
   * @return \Pyrin\Core\HTML\Element
   */
  public function block() {
    $this->inline = false;
    return $this;
  }
  
  /**
   * Converts this elmeent into an inline element.
   * @return \Pyrin\Core\HTML\Element
   */
  public function inline() {
    $this->inline = true;
    return $this;
  }
  
  /**
   * Returns the rendered HTML of this element.
   * @return string The rendered html of this element.
   */
  public function __toString() {
    return $this->html();
  }
  
  /**
   * Returns the rendered HTML of this element.
   * @return string The rendered html of this element.
   */
  public function html() {
    // Prerender the Elements Attributes.
    $attributes = $this->render_attributes();
    
    // Render the opening tag.
    $render = sprintf('<%s%s>', $this->tag, $attributes);
    
    if ( $this->void === TRUE ) {
      return $render;
    }
    
    // Render Text
    if ( !empty($this->text) ) {
      $render .= $this->text;
    }
    
    // Render Children
    elseif ( count($this->children) ) {
      $render .= $this->render_children();
    }
    
    // Finally, render the closing tag
    $render .= sprintf('</%s>', $this->tag);
    
    // Return the Rendered HMTL
    return $render;
  }

  /**
   * Render's this element's children.
   * @return string The rendered Children
   */
  protected function render_children() {
    $render = '';
    foreach ( $this->children as $child ) {
      if ( is_a($child, '\Pyrin\Core\Render\HTML\Element') ) {
        // Render this Child
        $render .= $child->html();
      }
    }
    return $render;
  }
  
  /**
   * Renders all the HTML Attributes.
   * @return string The rendered HTML.
   */
  private function render_attributes() {
    $render = '';
    foreach ( $this->attributes as $attribute => $value ) {
      $render .= sprintf(' %s="%s"', $attribute, $value);
    }
    return $render;
  }
  
  /**
   * Gets the number of child elements.
   * @return int The number of child elements.
   */
  public function length() {
    return count($this->children);
  }
    
  /**
   * Adds a child element to the end of the array.
   * @param string|element $element
   */
  public function append($element) {
    // Don't add children to void elements.
    if ( $this->void ) {
      trigger_error('Cannot append child elements to void element "' . $this->tag . '".', E_USER_ERROR);
      exit();
      //to undefined property via __get(): ' . $name . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'], E_USER_NOTICE);
    }
    
    $this->children[] = $this->verify_element($element);
    
    // Return this for chaining.
    return $this;
  }
  
  public function &_append($element) {
    $this->children[] = $this->verify_element($element);
    return $element;
  }
  
  private function verify_element(&$element) {
    if ( $this->is_tag($element) ) {
      $element = new Element($element);
    }
    return $element;
  }
  
  // Need to make this parse and confirm.
  private function is_tag($string) {
    if (is_string($string) ) {
      return true;
    } else {
      return false;
    }
  }


  /**
   * Get the value of an attribute or set one or more attributes for every matched element.
   * @param string $attribute The name of the attribute to get or set.
   * @param mixed|null $value A value to set for the attribute. If null, the specified attribute will be returned.
   * @return \Pyrin\Core\HTML\Element
   */
  public function attr($attribute, $value = NULL) {
    if ( is_null($value) && array_key_exists($attribute, $this->attributes) ) {
      return $this->attributes[$attribute];
    } else {
      $this->attributes[$attribute] = $value;
      return $this;
    }
  }
  
  
  
}
