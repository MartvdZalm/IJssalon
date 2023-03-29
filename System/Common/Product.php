<?php
namespace System\Common;

use System\DB\Database;

class Product
{
  private $id;

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

  public function getBrand()
  {
      $query = "SELECT brand.Name AS `Brand` FROM product 
      LEFT JOIN brand ON product.Brand = brand.id WHERE product.id = $this->id";
      return $this->pdo->query($query);
  }

  public function getId()
  {
      return $this->id;
  }

  public function deleteProduct($id)
  {
      $query = "DELETE FROM product WHERE id=?";
      $this->pdo->query($query, array($id));
  }

  public function changeValues($data, $images)
  {
    if ($images['image'] != null) {
      $query = "UPDATE product SET Name=?, Price=?, Description=?, Image=?, Quantity=?, FlavourOfTheDay=?, Brand=? WHERE product.id=$this->id";
      $params = array($data['name'], $data['price'], $data['description'], $images['image'], $data['quantity'], $data['flavourOfTheDay'], $data['brand'],); 
    } else {
      $query = "UPDATE product SET Name=?, Price=?, Description=?, Quantity=?, FlavourOfTheDay=?, Brand=? WHERE product.id=$this->id";
      $params = array($data['name'], $data['price'], $data['description'], $data['quantity'], $data['flavourOfTheDay'], $data['brand'],);
    }

    $this->pdo->query($query, $params);
  }
}