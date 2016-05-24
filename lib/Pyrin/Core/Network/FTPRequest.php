<?php

namespace Pyrin\Core\Network;

class FTPRequest {
  protected $connection;
  public $host;
  public $port;
  public $username;
  public $password;
  public $timeout;
  public $actions = array();
  public $mode = FTP_BINARY;
  
  public function __construct($host = '', $port = '', $username = '', $password ='', $timeout = 90) {
    $this->host = $host;
    $this->port = $port;
    $this->username = $username;
    $this->password = $password;
    $this->timeout = $timeout;
  }

  //put your code here
  public function upload($local, $remote) {
    $this->actions[] = array('mode' => 'upload_file', 'local' => $local, 'remote' => $remote);
    return $this;
  }
  
  public function download($remote, $local) {
    $this->actions[] = array('mode' => 'download_file', 'local' => $local, 'remote' => $remote);
    return $this;
  }
  
  public function uploadData($data, $remote) {
    $this->actions[] = array('mode' => 'upload_data', 'data' => $data, 'remote' => $remote);
    return $this;
  }
  
  public function fetchData($remote) {
    // Remote File Stream
    $remote_file = $this->remote_file(array('remote' => $remote));
    $remote_contents = file_get_contents($remote_file);
    return $remote_contents;
  }
  
  public function execute() {
    foreach($this->actions as $action) {
      $this->{$action['mode']}($action);
    }
    
    $this->actions = array();
    return $this;
  }
  
  protected function remote_file($file) {
    $remote_file = sprintf('ftp://%s:%s@%s:%s/%s', $this->username, $this->password, $this->host, $this->port, $file['remote']);
    return $remote_file;
  }
  
  protected function upload_data($file) {
    // Remote File Stream
    $remote_file = $this->remote_file($file);
    $remote_options = array('ftp' => array('overwrite' => true));
    $remote_context = stream_context_create($remote_options);
    file_put_contents($remote_file, $file['data'], NULL, $remote_context);
  }

  protected function download_file($file) {
    // Remote File Stream
    $remote_file = $this->remote_file($file);
    $remote_contents = file_get_contents($remote_file);
    
    // Local File
    $local_file = fopen($file['local'], 'w');
    fwrite($local_file, $remote_contents);
    fclose($local_file);
  }

  protected function upload_file($file) {
    // Remote File Stream
    $remote_file = $this->remote_file($file);
    $remote_options = array('ftp' => array('overwrite' => true));
    $remote_context = stream_context_create($remote_options);
   
    // Local File
    $local_contents = file_get_contents($file['local']);
    file_put_contents($remote_file, $local_contents, NULL, $remote_context);
  }
}

