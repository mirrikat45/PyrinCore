<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Variable\Data;

class URLRequest {
  protected $SECURE;
  protected $URL;
  public $header;
  public $data;
  public $results;

  public function __construct($url, $secure = TRUE) {
    $this->SECURE = $secure;
    $this->URL = parse_url($url);
    $this->data = new Data();
    $this->header = new Data();
    $this->parse_query();
  }
  
  protected function parse_query() {
    $URL = $this->URL;
    if ( !empty($URL['query']) ) {
      $query = $this->URL['query'];
      parse_str($query, $query_variables);
      foreach ($query_variables as $variable => $value ) {
        $this->addData($variable, $value);
      }
    }
  }
  protected function url($use_query = FALSE) {
    $URL = $this->URL;
    // HTTP, HTTPS...
    $scheme = $URL['scheme'];
    
    // Determine Authentication
    $auth = !empty($URL['user']) && !empty($URL['pass']) ? ($this->URL['user'] . ':' . $this->URL['pass'] . '@') : '';
    
    // domain
    $host = $URL['host'];
    
    // Determine Port
    $port = !empty($URL['port']) ? ':' . $URL['port'] : '';
    
    // Path
    $path = $URL['path'];
    
    // Query
    if ( $use_query ) {
      $query = http_build_query($this->data->getArray());
      if ( !empty($query) ) $query = '?' . $query;
    } else {
      $query = '';
    }
    
    // Build the final url
    return sprintf('%s://%s%s%s%s%s', $scheme, $auth, $host, $port, $path, $query);
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
    $this->data->add($property, $value);
    return $this;
  }
  
  /**
   * Adds a header attribute to the request.
   * 
   * @param string $variable
   * The name of the attribute or variable to store.
   * 
   * @param object $value
   * The value to store in the attribute.
   * 
   * @return \PyrinRequest
   */
  public function addHeader($variable, $value) {
    // Todo, throw error if an attribute already exists.
    $this->header->add($variable, $value);
    return $this;
  }
  
  protected function curl() {
    // New Curl Object
    $curl = curl_init();
    
    // Misc Options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Add Support for Insecure Transactions
    if ( $this->SECURE === false ) {
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
    if ( !empty($header_data) ) {
      foreach ( $header_data as $header => $setting ) {
       $headers[] = sprintf('%s: %s', $header, (string)$setting);
      }
    }
    if ( !empty($headers) ) {
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
  }
  
  public function execute() {
    $curl = $this->curl();
    curl_setopt($curl, CURLOPT_URL, $this->url(false));
    $this->results = curl_exec($curl);
    return $this;
  }
  
  public function __toString() {
    return $this->results;
  }
  
    /**
   * Returns the results as a JSON Object.
   * @return JSON
   */
  public function getJSON() {
    return json_decode($this->results);
  }
}
