<?php

namespace Pyrin\Core\Network;

class FTPConnection {
  protected $connection;
  
  public function __construct($host = '', $port = '', $username = '', $password ='', $timeout = 90) {
    // Connect to FTP
    $connection = ftp_connect($host, $timeout);
    if ( $connection === FALSE ) die('FTP Connection Error');
    ftp_login($connection, $username, $password);
    
    // Set the connection variable.
    $this->connection = &$connection;
  }
  
  /**
   * Downloads a file from the FTP server
   * @param string  $remote The remote file path.
   * @param string  $local The local file path (will be overwritten if the file already exists).
   * @param string  $mode The transfer mode. Must be either FTP_ASCII or FTP_BINARY.
   * @return bool Returns TRUE on success or FALSE on failure.
   */
  public function download($remote, $local, $mode = FTP_BINARY) {
    ftp_get($this->connection, $local, $remote, $mode);
    return $this;
  }
  
  /**
   * Uploads a local file to the ftp server.
   * @param string $local The local file path.
   * @param string $remote The remote file path.
   * @param string $mode The transfer mode. Must be either FTP_ASCII or FTP_BINARY.
   * @return bool Returns TRUE on success or FALSE on failure.
   */
  public function upload($local, $remote, $mode = FTP_BINARY) {
    ftp_put($this->connection, $remote, $local, $mode);
    return $this;
  }
  
  /**
   * Returns an array of filenames from the specified directory on success or FALSE on error.
   */
  public function ls() {
    $files = ftp_nlist($this->connection, '.');
    return $files;
  }
  
    /**
   * Closes the FTP Connection
   * @return \Pyrin\Core\Request\FTPConnection
   */
  public function close() {
    ftp_close($this->connection);
    return $this;
  }
}
