<?php

namespace Pyrin\API\iContact;

use Pyrin\Core\Variable\Data;

class Contact extends Data {
  private $iContact;
  
  public function __construct($attributes, $iContact) {
    $this->iContact = $iContact;
    $this->value($attributes);
    
    // Load existing data about this contact.
    $this->load();
  }
  
  private function load($overwrite = FALSE) {
    if ( !empty($this->email) ) {
      $request = $this->iContact->request('contacts', 'GET');
      $request->addData('email', $this->email);
      $this->merge($request->getContact(), $overwrite);
    }
    return $this;
  }
  
  public function save() {
    // Write the contact.
    $request = $this->iContact->request('contacts', 'POST')
        ->addData('contact', $this->getArray())
        ->execute();
    
    // Load the Newly Created Contact
    return $this->load(TRUE);
  }
  
  public function subscribe($listId, $status = 'normal') {
    if ( !empty($this->contactId) ) {
      $request = $this->iContact->request('subscriptions', 'POST')
        ->addData('contact', array(
          'contactId' => $this->contactId,
          'listId' => $listId,
          'status' => $status,
        ))
        ->execute();
      return $this;
    } else {
      return false;
    }
  }
  
  public function getSubscriptions() {
    if ( !empty($this->contactId) ) {
      return $this->iContact->request('subscriptions', 'GET')
          ->addData('contactId', $this->contactId)
          ->getSubscriptions();
    } else {
      return false;
    }
  }
}
