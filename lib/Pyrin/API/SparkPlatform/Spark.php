<?php

namespace Pyrin\API\SparkPlatform;

use \Pyrin\API\SparkPlatform\SparkRequest;
use Pyrin\Core\Variable\Data;

class Spark {
  protected $ApiKey;
  protected $ApiSecret;
  public $AuthToken;
  
  public function __construct() {
  }
  
  /* Actual API! */
  public function GetSystemInfo() {
    $request = new SparkRequest('system', 'GET');
    return $this->execute($request);
  }
  
  public function AddContact(Array $contact) {
    // Check if Contact already exists.
    if ( $existing_contact = $this->GetContact($contact) ) {
      return $existing_contact;
    }
    
    $request = new SparkRequest('contacts', 'POST');
    $request->addSparkData($contact);
    $results = $this->execute($request);
    return $results;
  }
  
  public function GetContact(Array $contact) {
    $request = new SparkRequest('contacts', 'GET');
    $request->addData('_filter', 'PrimaryEmail eq \'' . $contact['PrimaryEmail'] . '\'');
    $results = $this->execute($request);
    if ( !empty($results->Results[0]) ) {
      return $results->Results[0];
    } else {
      return false;
    }
  }
  
    /* Automated System */
  private function execute(&$request) {
    return $this->authenticate($request)->execute()->getJSON();
  }
  
  private function authenticate(&$request) {
    if ( empty($this->AuthToken) ) {
      $this->AuthToken = $this->get_auth_token() or die("Unable to Authenticate credentials with SparkAPI.");
    }
    $request->addData('AuthToken', $this->AuthToken);
    $this->signRequest($request);
    return $request;
  }
  
  private function signRequest(&$request) {
    $request->sign($this->ApiSecret, $this->ApiKey);
    return $request;
  }
  
  private function get_auth_token() {
    $request = new SparkRequest('session', 'POST');
    $authentication = $this->signRequest($request)
      ->addData('ApiKey', $this->ApiKey)
      ->getJSON();
    
    // Set the Authentication Token
    if ( !empty($authentication->Success) ) {
      return $authentication->Results[0]->AuthToken;
    } else {
      return FALSE;
    }
  }
}
