<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Network\URLRequest;

class GETRequest extends URLRequest {

  public function execute() {
    $curl = $this->curl();
    curl_setopt($curl, CURLOPT_URL, $this->url(TRUE));
    $this->results = curl_exec($curl);
    return $this;
  }
}
