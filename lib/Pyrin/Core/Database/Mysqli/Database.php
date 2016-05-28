<?php

namespace Pyrin\Core\Database\Mysqli;

use Pyrin\Core\Database\DatabaseInterface;

class Database implements DatabaseInterface {
  protected static $instance;
  
  protected $connection;
  protected $user;
  protected $password;
  protected $default_schema;
  protected $host = 'localhost';
  protected $port = 3306;
  protected $socket = NULL;
  
  private function __clone() {}
  private function __wakeup() {}
  protected function __construct() {
      $this->connect();
  }
  
  public static function getInstance() {
    if (null === static::$instance) {
        static::$instance = new static();
    }
    return static::$instance;
  }
  
  public function connect($schema = NULL) {
    if ( !isset($schema) ) $schema = $this->default_schema;
    $this->connection = new \mysqli($this->host, $this->user, $this->password, $schema, $this->port, $this->socket);
    return $this;
  }
  
  public function __call($method_name, $args) {
    return  call_user_func_array(array($this->connection, $method_name), $args);
  }
  
  /** Actually, this should be within the child Classes. */
  public function execute() {
    
  }
  

}