<?php

namespace Pyrin\Core\Email;

use Pyrin\Core\Email\EmailInterface;
use Pyrin\Core\Variable\Data;
use Pyrin\Core\Network\Headers;
use Pyrin\Core\Network\HeadersInterface;

class Email implements EmailInterface, HeadersInterface {
  
  private $subject;
  private $message;
  private $reply_to;
  
  /**
   * @var Pyrin\Core\Network\Headers
   */
  private $headers;
  
  /**
   * @var Pyrin\Core\Network\Headers
   */
  private $data;
  
  /**
   * @var Array
   */
  private $to = array();
  
  /**
   * @var Array
   */
  private $cc = array();
  
  /**
   * @var Array
   */
  private $bcc = array();
  
   /**
   * Creates a new Email.
   * @param string|null $from The sender email address for this email.
   * @param string|null $subject A subject for this email.
   * @param string|null $message A message for this email.
   * @return \Pyrin\Core\Email\Email
   */
  public static function create($from = NULL, $subject = NULL, $message = NULL) {
    return new Email($from, $subject, $message);
  }
  
  /**
   * Creates a new Email.
   * @param string|null $from The sender email address for this email.
   * @param string|null $subject A subject for this email.
   * @param string|null $message A message for this email.
   */
  public function __construct($from = NULL, $subject = NULL, $message = NULL) {
    $this->headers = new Headers();
    $this->data = new Headers();
    $this->subject = $subject;
    $this->message = $message;
    $this->addHeader('X-Mailer', 'Pyrin/PHP' . phpversion());
    if ( isset($from) ) {
      $this->addHeader('From', $from);
    }
  }
  
  /**
   * Adds a name and/or email to the recipient list.
   * @param string $name This can either be a name or an email address.
   * @param string|null $email If this is set, the to message is formated as NAME <EMAIL>
   * @return \Pyrin\Core\Email\Email
   */
  public function to($name, $email = NULL) {
    if ( isset($email) ) {
      $name .= ' <' . $email . '>';
    }
    $this->to[] = $name;
    return $this;
  }
  
  /**
   * Adds an email to CC
   * @param string $email The email to add to the cc list.
   * @return \Pyrin\Core\Email\Email
   */
  public function cc($email) {
    $this->cc[] = $email;
    return $this;
  }
  
  /**
   * Adds an email to BCC
   * @param string $email The email to add to the bcc list.
   * @return \Pyrin\Core\Email\Email
   */
  public function bcc($email) {
    $this->bcc[] = $email;
    return $this;
  }
  
  /**
   * Sets the from header for this email.
   * @param type $email
   * @return \Pyrin\Core\Email\Email
   */
  public function from($email) {
    $this->from = $email;
    return $this;
  }
  
  /**
   * Sends the email alert.
   * @return bool TRUE if successful FALSE otherwise.
   */
  public function send() {
   $to = implode(', ', $this->to);
   $message = '';
   
   // Add CC
   if ( !empty($this->cc) ) {
     $this->addHeader('Cc', implode(', ', $this->cc));
   }
   
   // Add BCC
   if ( !empty($this->bcc) ) {
     $this->addHeader('Bcc', implode(', ', $this->bcc));
   }
   
   // Get the Headers
   $headers = $this->headers->value();
  
   // Add the Core Message body.
   if ( isset($this->message) ) {
     $message .= $this->message . "\r\n";
   }
   
   // Add the Message Data body
   $data = $this->data->value();
   if ( !empty($data) ) {
     $message .= $data;
   }
   
   // Send the Mail
   return mail($to, $this->subject, $message, $headers);
  }
  
  /**
   * Adds a header attribute to the email.
   * @param string $property The name of the attribute or variable to store.
   * @param mixed $value The value to store in the attribute.
   * @return \URLRequest
   */
  public function addHeader($property, $value) {
    $this->headers->{$property} = $value;
    return $this;
  }
  
  /**
   * Gets the headers array.
   * @return array
   */
  public function getHeaders() {
    return $this->headers->getArray();
  }
  
  /**
   * Adds a message data attribute to the email.
   * @param string $property The name of the attribute or variable to store.
   * @param mixed $value The value to store in the attribute.
   * @return \Pyrin\Core\Email\Email
   */
  public function addData($property, $value) {
    $this->data->{$property} = $value;
    return $this;
  }
  
  
}



    

    


