<?php
namespace System\Common;

use System\DB\Database;

class Brands
{   
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getBrands()
    {
        $query = "SELECT * FROM brand";
        return $this->pdo->query($query);
    }
}