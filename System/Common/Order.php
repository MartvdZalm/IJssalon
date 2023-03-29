<?php
namespace System\Common;

use System\DB\Database;

class Order
{
    private $id;

    private $pdo;

    public function __construct($id)
    {
        $this->id = $id;
        $this->pdo = new Database();
    }

    public function getOrder()
    {
        $query = "SELECT `order`.*, users.Username AS 'Name' FROM `order` LEFT JOIN users ON `order`.user = users.id WHERE `order`.id = ?";
        return $this->pdo->queryOneRow($query, array($this->id));
    }

    public function getProducts()
    {
        $query = "SELECT product.* FROM `order` LEFT JOIN orderproduct ON orderproduct.Order = `order`.`id`
        LEFT JOIN product ON product.id = orderproduct.Product WHERE `order`.`id`=?";
        return $this->pdo->query($query, array($this->id));
    }

    public function accept()
    {
        $query = "UPDATE `order` SET Status='ACCEPTED' WHERE id=?";
        $this->pdo->query($query, array($this->id));
    }

    public function cancel()
    {
        $query = "UPDATE `order` SET Status='CANCELED' WHERE id=?";
        $this->pdo->query($query, array($this->id));
    }
}