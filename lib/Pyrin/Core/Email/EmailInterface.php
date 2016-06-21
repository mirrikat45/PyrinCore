<?php

namespace Pyrin\Core\Email;

interface EmailInterface {
  /**
   * Adds an email address to the list of recipients.
   * @param String $email The email address to add to the send list.
   */
  public function to($email);

  /**
   * Sets the "From" email address for outgoing email.
   * @param String $email the FROM email to set.
   */
  public function from($email);
  
  /**
   * Adds an email address to the list of CC recipients.
   * @param String $email The email to add to the cc list.
   */
  public function cc($email);
  
  /**
   * Adds an email address to the list of BCC recipients.
   * @param type $email The email to add to the bcc list.
   */
  public function bcc($email);
  
  /**
   * Sends the email.
   */
  public function send();
  
  
  
  
}
