<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Variable\Data;

class Url extends \Pyrin\Core\Variable\Data {
  public function __construct($url) {
    // Parse the URL and convert it to DATA
    $url_array = parse_url($url);
    $this->value($url_array);
    
    // Convert the Query to data as well
    parse_str($this->query, $query);
    $this->query = new Data($query);
  }

  public function __toString() {
    return $this->getString();
  }
  
  public function getString() {
    $scheme = !empty($this->scheme) ? $this->scheme : 'http';
    $auth = !empty($this->user) && !empty($this->pass) ? ($this->user . ':' . $this->pass . '@') : '';
    $host = $this->host;
    $port = $this->port;
    $path = $this->path;
    $query_array = $this->query->getArray();
    $query = !empty($query_array) ? ('?' . http_build_query($this->query->getArray())) : '';
    $fragment = !empty($this->fragment) ? '#' . $this->fragment : '';
    return sprintf('%s://%s%s%s%s%s', $scheme, $auth, $host, $port, $path, $query, $fragment);
  }
}
