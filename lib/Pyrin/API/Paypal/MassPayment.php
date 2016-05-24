<?php

namespace Pyrin\API\Paypal;

use Pyrin\Core\Request\GETRequest;

class MassPayment extends GETRequest  {
  private $end_point = 'https:/ /api-3t.sandbox.paypal.com/nvp';
  private $username = 'kevin_api1.tentonhammer.com';
  private $password = '1381598925';
  private $signature = 'AGBXEGYbaut6MQKH13jT1BNVqmndAlvQEeBle7P1P0an4opCbPFGcRJh';
  private $version = 90;
  private $currencyCode = 'USD';
  private $payees = 0;
  
  public function __construct() {
    parent::__construct($this->end_point);
    $this->addData('METHOD', 'MassPay')
         ->addData('VERSION', $this->version)
         ->addData('USER', $this->username)
         ->addData('PWD', $this->password)
         ->addData('SIGNATURE', $this->signature)
         ->addData('RECEIVERTYPE', 'EmailAddress')
         ->addData('CURRENCYCODE', 'USD');
        
    return $this;
  }
  
  public function addPayment($email, $amount) {
    // The current id should be the value of Payees.
    $id = $this->payees;
    
    // Add a new email and amount to the data.
    $this->addData('L_EMAIL' . $id, $email)
        ->addData('L_AMT' . $id, $amount);
    
    // Update the number of payees.
    $this->payees++;
    return $this;
  }
}
