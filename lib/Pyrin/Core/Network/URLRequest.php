<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Variable\Data;

class URLRequest {
  protected $executed = false;
  protected $secure;
  public $method;
  public $url;
  public $header;
  public $data;
  public $options;
  public $results;
  public $info;

  public function __construct($url, $method = 'GET', $secure = TRUE) {
    $this->secure = $secure;
    $this->method = $method;
    $this->url = new Url($url);
    $this->data = new Data($this->url->query);
    $this->header = new Data();
    $this->options = new Data();
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
  
  /**
   * Adds a curl option to the request.
   * @param string $property The name of the attribute or variable to store.
   * @param mixed $value The value to store in the attribute.
   * @return \URLRequest
   */
  public function addOption($property, $value) {
    // Todo, throw error if an attribute already exists.
    $this->options->{$property} = $value;
    return $this;
  }
  
  protected function curl() {
    // New Curl Object
    $curl = curl_init();
    
    // Misc Options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
    
    // Add Support for Insecure Transactions
    if ( $this->secure === false ) {
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    }
    
    // Attach Headers
    $this->curl_headers($curl);
    
    // Attach Curl Options
    $this->curl_options($curl);
    
    // Set the Curl URL
    curl_setopt($curl, CURLOPT_URL, $this->url->getString());
  
    // Return the Curl Object
    return $curl;
  }
  
  /**
   * Attaches Curl Options to the request.
   * @param resource $curl The Curl Resource to apply options to.
   */
  protected function curl_options(&$curl) {
    $options = $this->options->getArray();
    if ( !empty($options) ) {
      foreach ($options as $option => $value) {
        curl_setopt($curl, constant('CURLOPT_' . $option), $value);
      }
    }
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
  
  public function curl_POST() {
    $data = $this->data->getArray();
    $this->addOption('POST', count($data));
    $this->addOption('POSTFIELDS', http_build_query($data));
  }
  
  public function curl_GET() {
    $this->url->query->value($this->data);
  }


  public function execute() {
    if ( $this->executed ) return $this;
    
    $data = $this->data->getArray();
    
    // Call the method constructor.
    call_user_method('curl_' . $this->method, $this);
    
    // Execute Curl
    $curl = $this->curl();
    $this->results = curl_exec($curl);
    $this->info = curl_getinfo($curl);
    curl_close($curl);
    $this->executed = true;
    
    // Return this Object
    return $this;
  }
  
  public function __toString() {
    return (string)$this->execute()->results;
  }
  
  /**
 * Returns the results as a JSON Object.
 * @return JSON
 */
  public function getJSON() {
    return json_decode($this->execute()->results);
  }
  
}
