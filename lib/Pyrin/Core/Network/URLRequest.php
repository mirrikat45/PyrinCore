<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Variable\Data;

class URLRequest {
  protected $executed = false;
  protected $secure;
  public $url;
  public $header;
  public $data;
  public $results;

  public function __construct($url, $secure = TRUE) {
    $this->secure = $secure;
    $this->url = new Url($url);
    $this->data = new Data($this->url->query);
    $this->header = new Data();
  }

  /**
   * Adds a data attribute to the request.
   * 
   * @param string $variable
   * The name of the attribute or variable to store.
   * 
   * @param object $value
   * The value to store in the attribute.
   * 
   * @return \PyrinRequest
   */
  public function addData($property, $value) {
    // Todo, throw error if an attribute already exists.
    $this->data->{$property} = $value;
    return $this;
  }
  
  /**
   * Adds a header attribute to the request.
   * @param string $property The name of the attribute or variable to store.
   * @param mixed $value The value to store in the attribute.
   * @return \URLRequest
   */
  public function addHeader($property, $value) {
    // Todo, throw error if an attribute already exists.
    $this->header->{$property} = $value;
    return $this;
  }
  
  protected function curl() {
    // New Curl Object
    $curl = curl_init();
    
    // Misc Options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Add Support for Insecure Transactions
    if ( $this->secure === false ) {
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    }
    
    // Attach Headers
    $this->curl_headers($curl);
  
    // Return the Curl Object
    return $curl;
  }
  
  protected function curl_headers(&$curl) {
    $headers = array();
    $header_data = $this->header->getArray();
    foreach ( $header_data as $header => $setting ) {
     $headers[] = sprintf('%s: %s', $header, (string)$setting);
    }
    if ( !empty($headers) ) {
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
  }
  
  public function execute() {
    $this->executed = true;
    $curl = $this->curl();
    curl_setopt($curl, CURLOPT_URL, $this->url->getString());
    $this->results = curl_exec($curl);
    return $this;
  }
  
  public function __toString() {
    if ( !$this->executed ) {
      $this->execute();
    }
    return (string)$this->results;
  }
  
  /**
 * Returns the results as a JSON Object.
 * @return JSON
 */
  public function getJSON() {
    return json_encode($this->results);
  }
}
