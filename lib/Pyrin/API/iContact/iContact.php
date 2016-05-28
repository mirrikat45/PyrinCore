<?php

namespace Pyrin\API\iContact;

use Pyrin\API\iContact\Contact;
use Pyrin\API\iContact\iContactRequest;
use Pyrin\Core\Network\Url;


class iContact {
  protected $ApiVersion;
  protected $ApiAppId;
  protected $ApiUsername;
  protected $ApiPassword;
  protected $AccountID;
  protected $ClientFolderID;
  private $ApiURL;

  public function __construct() {
    $url = sprintf('https://app.icontact.com/icp/a/%s/c/%s/', $this->AccountID, $this->ClientFolderID);
    $this->ApiURL = new Url($url);
  }
  
  public function request($uri, $method) {
    $url = $this->ApiURL->getString() . $uri;
    $request = new iContactRequest($url, $method, FALSE);
    $request->addHeader('Accept', 'application/json')
        ->addHeader('Content-Type', 'application/json')
        ->addHeader('Api-Version', $this->ApiVersion)
        ->addHeader('Api-AppId', $this->ApiAppId)
        ->addHeader('Api-Username', $this->ApiUsername)
        ->addHeader('Api-Password', $this->ApiPassword);
    return $request;
  }
  
  public function newContact($attributes = array()) {
    // Create the Contact
    $contact = new Contact($attributes, $this);
    return $contact;
    
    // Verify the Contact
    //$subscriptions = $this->getSubscription($contact);
  }
  
  public function getContact($email) {
    $attributes = array('email' => $email);
    return new Contact($attributes, $this);
  }
  
}
