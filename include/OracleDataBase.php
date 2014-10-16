<?php

class OracleDataBase
{
  private $username;
  private $password;
  private $host;
  private $port;
  private $connection;
  private $tcn_connection;

  public function __construct($username, $password, $host, $port) {
    $this->tcn_connection = "
    (DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
        (CONNECT_DATA =
          (SERVER = DEDICATED)
          (SERVICE_NAME = ADB)
        )
    )";

      $this->username = $username;
      $this->password = $password;
  }

  public function connect() {
    $this->connection = oci_connect($this->username,
      $this->password, $this->tcn_connection);
  }

  public function get_connection() {
    return $this->connection;
  }

  public function query($sql) {
    $q = oci_parse($this->connection, $sql);
    oci_execute($q, OCI_DEFAULT);
    $err = oci_error($q);

    if (!$err)
      return $q;
    else
      return $err;
  }

  public function select($sql) {
    $res = $this->query($sql);
    $results = array();

    while(($row = oci_fetch_assoc($res)) != false) {
      $results[] = array_change_key_case($row, CASE_LOWER);
    }

    return $results;
  }

  public function insert($sql) {
    $this->query($sql);
    oci_commit($this->connection);
  }

  public function commit() {
    oci_commit($this->connection);
  }

  public function close() {
    oci_close($this->connection);
  }

}


?>
