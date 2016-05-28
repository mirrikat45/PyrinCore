<?php

namespace Pyrin\API\SparkPlatform;

use Pyrin\Core\Network\URLRequest;
use \Pyrin\Core\Variable\Data;

class SparkRequest extends URLRequest {
  public $version = 1;
  public $method;
  public $uri;
  public $sparkData;
  
  public function __construct($uri, $method) {
    $this->uri = $uri;
    $url = 'https://sparkapi.com/v' . $this->version . '/' . $uri;
    parent::__construct($url, $method, FALSE);
    $this->addHeader('Content-Type', 'application/json')
        ->addHeader('User-Agent', 'Spark API PHP Custom Client/1.0')
        ->addHeader('X-SparkApi-User-Agent', 'PHP-API-PYRIN-SPARK/1.0');
  }
  
  public function sign($ApiSecret, $ApiKey) {
    
    $data = $this->data->getArray();
    $encryptedData = '';
    $servicePath = '';
    
    if ( !empty($data) ) {
      $servicePath = 'ServicePath/v' . $this->version . '/' . rawurldecode($this->uri);
      ksort($data);
      foreach ( $data as $key => $value ) {
        $encryptedData .= $key . $value;
      }
    }
    
    $sparkData = isset($this->sparkData) ? $this->sparkData : '';
    $signature = md5(sprintf('%sApiKey%s%s%s%s', $ApiSecret, $ApiKey, $servicePath, $encryptedData, $sparkData));
    $this->addData('ApiSig', $signature);
  }
  
  public function curl_POST() {
    $this->url->query->value($this->data);
    
    $this->addOption('URL', $this->url->getString());
    $this->addOption('POST', 1);
    $this->addOption('POSTFIELDS', $this->getSparkData());
  }
  
  public function getJSON() {
    $json = parent::getJSON();
    return $json->D;
  }
  
  public function getSparkData() {
    if ( !empty($this->sparkData) ) {
      return $this->sparkData;
    } else {
      return json_encode(array());
    }
  }
  
  public function addSparkData($data) {
    $this->sparkData = json_encode(array('D' => $data));
    return $this;
  }
}
