<?php

namespace Pyrin\Core\Request;

use Pyrin\Core\Request\URLRequest;

class POSTRequest extends URLRequest {
  //put your code here
  public function execute() {
    $curl = $this->curl();
    curl_setopt($curl, CURLOPT_URL, $this->url(false));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    $data = $this->data->getArray();
    curl_setopt($curl,CURLOPT_POST, count($data));
    curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query($data));
    $this->results = curl_exec($curl);
    return $this;
  }
}
