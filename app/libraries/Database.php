<?php
/**
 * PDO database class
 * Connect to MYSQL database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */

class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $password = DB_PASSWORD;
  private $dbname = DB_NAME;

  private $dbh;
  private $statement;
  private $error;

  public function __construct()
  {
    // Create DSN
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    // Create PDO Instance
    try {
      $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
    } catch (PDOException $err) {
      $this->error = $err->getMessage();
      echo $this->error;
    }
  }
}
