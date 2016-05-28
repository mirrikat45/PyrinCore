<?php

namespace Pyrin\Core\Database;

interface DatabaseInterface {
  public function execute();
  public function connect();
  public function __call($name, $arguments);
  
}
