<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Network\URLRequest;

class GETRequest extends URLRequest {
  public function execute() {
    $this->executed = true;
    $curl = $this->curl();
    $this->url->query->value($this->data);
    curl_setopt($curl, CURLOPT_URL, $this->url->getString());
    $this->results = curl_exec($curl);
    return $this;
  }
}
