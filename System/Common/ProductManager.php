<?php
namespace System\Common;

use System\DB\Database;

class ProductManager
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getProducts()
    {
        $query = "SELECT * FROM product";
        return $this->pdo->query($query);
    }

    public function getProductOfTheDay()
    {
        $query = "SELECT * FROM product WHERE FlavourOfTheday = TRUE LIMIT 1";
        return $this->pdo->queryOneRow($query);
    }

    public function getBestSelling()
    {
        $query = "SELECT * FROM product ORDER BY Bought DESC LIMIT 3";
        return $this->pdo->query($query);
    }

    public function addProduct($data, $images)
    {
        $query = "INSERT INTO product (Name, Price, Description, Image, Quantity, Brand) VALUES (?, ?, ?, ?, ?, ?)";
        $params = array($data['name'], $data['price'], $data['description'], $images['image'], $data['quantity'], $data['brand']);
        $this->pdo->query($query, $params);
    }
}