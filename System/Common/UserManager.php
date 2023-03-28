<?php
namespace System\Common;

use System\DB\Database;

class UserManager
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getUsers()
    {
        $query = "SELECT * FROM users";
        return $this->pdo->query($query);
    }
}