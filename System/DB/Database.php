<?php
namespace System\DB;


class Database 
{
    private $pdo;
  
    public function __construct()
    {  
      try {
        $this->pdo = new \PDO("mysql:host=".DB_HOSTNAME.";dbname=".DB_DATABASE.";charset=utf8", DB_USERNAME, DB_PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      } catch(\PDOException $e) {
        die("Failed to connect to database: " . $e->getMessage());
      }
    }
  
    public function query($query, $params = array())
    {
      $statement = $this->pdo->prepare($query);
      $statement->execute($params);
  
      return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
  
    public function execute($query, $params = array())
    {
      $statement = $this->pdo->prepare($query);
      $statement->execute($params);
  
      return $statement->rowCount();
    }
  
    public function lastInsertId()
    {
      return $this->pdo->lastInsertId();
    }
  
    public function beginTransaction()
    {
      $this->pdo->beginTransaction();
    }
  
    public function commit()
    {
      $this->pdo->commit();
    }
  
    public function rollback()
    {
      $this->pdo->rollback();
    }
}
  