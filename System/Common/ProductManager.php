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

    public function getNewest()
    {
        
    }

    public function getBestSelling()
    {

    }
}