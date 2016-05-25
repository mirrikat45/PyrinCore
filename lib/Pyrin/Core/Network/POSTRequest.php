<?php

namespace Pyrin\Core\Network;

use Pyrin\Core\Network\URLRequest;

class POSTRequest extends URLRequest {
  //put your code here
  public function execute() {
    $this->executed = true;
    $curl = $this->curl();
    $data = $this->data->getArray();
    curl_setopt($curl, CURLOPT_URL, $this->url->getString());
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl,CURLOPT_POST, count($data));
    curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query($data));
    $this->results = curl_exec($curl);
    return $this;
  }
}
