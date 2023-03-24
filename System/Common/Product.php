<?php
namespace System\Common;

use System\DB\Database;

class Product
{
    private $id;

    private $name;

    private $price;

    private $description;

    private $pdo;

    public function __construct($id)
    {
        $this->id = $id;
        $this->pdo = new Database();
    }

    public function getProduct()
    {
      $query = "SELECT * FROM product WHERE id=:id";
      $param = array(':id' => $this->id);
      return $this->pdo->queryOneRow($query, $param);
    }
  
    public function getId()
    {
      return $this->id;
    }
  
    public function getName()
    {
      return $this->name;
    }
  
    public function getPrice()
    {
      return $this->price;
    }
  
    public function getDescription()
    {
      return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
  
    public function setPrice($price)
    {
      $this->price = $price;
    }
  
    public function setDescription($description)
    {
      $this->description = $description;
    }
}