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

  // Prepare statement with query
  public function query($sql)
  {
    $this->statement = $this->dbh->prepare($sql);
  }

  // Bind values
  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->statement->bindValue($param, $value, $type);
  }

  // Execute prepared statement
  public function execute()
  {
    return $this->statement->execute();
  }

  // Get result set as array of objects
  public function resultSet()
  {
    $this->execute();
    return $this->statement->fetchAll(PDO::FETCH_OBJ);
  }

  // Get record as single object
  public function single()
  {
    $this->execute();
    return $this->statement->fetch(PDO::FETCH_OBJ);
  }

  public function rowCount()
  {
    return $this->statement->rowCount();
  }
}
