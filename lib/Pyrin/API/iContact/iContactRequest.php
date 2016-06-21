<?php

namespace Pyrin\API\iContact;

use Pyrin\Core\Network\URLRequest;

class iContactRequest extends URLRequest {

  public function getContact($index = 0) {
    $results = $this->getJSON();
    print_r($results);
    if ( !empty($results->contacts) && array_key_exists($index, $results->contacts) ) {
      return (array)$results->contacts[$index];
    } else {
      return array();
    }
  }
  
  public function getSubscriptions() {
    $results = $this->getJSON();
    if ( !empty($results->subscriptions) ) {
      $subscriptions = array();
      foreach ( $results->subscriptions as $key => $sub ) {
        if ( isset($sub->listId) ) {
          $subscriptions[] = $sub->listId;
        }
      }
      return $subscriptions;
    } else {
      return false;
    }
  }
  
  public function curl_POST() {
    $data = $this->data->getArray();
    $json = json_encode($data);
    $this->addOption('POST', count($data));
    $this->addOption('POSTFIELDS', $json);
  }
}
